<?php
session_start();

if(!$_SESSION['is_playing']){
    header('Location: index.php');
    die;
}

if(!array_key_exists('row',$_POST) || !array_key_exists('column',$_POST)){
    //@todo: Flash error to user
    header('Location: index.php');
    die;
}

$coordinate = $_POST['row'].$_POST['column'];

$_SESSION['row_revealed'] = $_POST['row'];
$_SESSION['column_revealed'] = $_POST['column'];
//Check if it is a mine.
if(isMine($coordinate)){
    $_SESSION['states'][$coordinate] = 'MINE';
    $_SESSION['feedback'] = 'GAME OVER';
    $_SESSION['is_playing'] = false;
    header('Location: index.php');
    die;
}

$_SESSION['states'][$coordinate] = numberOfMinesConnected($_POST['row'],$_POST['column']);

$statesNotFlagged = array_filter($_SESSION['states'],function ($state){
    return $state !== 'FLAGGED';
});

if(count($statesNotFlagged) === 100 - count( $_SESSION['mines'])){
    $_SESSION['feedback'] = 'YOU WIN!!!!';
    $_SESSION['is_playing'] = false;
}

header('Location: index.php');
die;


function numberOfMinesConnected($row,$column){
    $possibleRows = range('A','J');
    $numberOfMinesConnected = 0;

    if($column != 10){
        $nextColumn = $column + 1;
        if(isMine($row.$nextColumn)){
            $numberOfMinesConnected++;
        }
    }
    if($column != 1){
        $previousColumn = $column - 1;
        if(isMine($row.$previousColumn)){
            $numberOfMinesConnected++;
        }
    }

    if($row != 'J'){
        $nextRow = $possibleRows[array_search($row,$possibleRows) + 1];
        if(isMine($nextRow.$column)){
            $numberOfMinesConnected++;
        }
    }
    if($row != 'A'){
        $previousRow = $possibleRows[array_search($row,$possibleRows) - 1];
        if(isMine($previousRow.$column)){
            $numberOfMinesConnected++;
        }
    }

    return $numberOfMinesConnected;
}

/**
 * Checks if a given coordinate is a mine
 * @param $coordinate
 * @return bool
 */
function isMine($coordinate){
    return in_array($coordinate,$_SESSION['mines']);
}