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
if(!array_key_exists($coordinate,$_SESSION['states'])){
    $_SESSION['states'][$coordinate] = 'FLAGGED';
}
header('Location: index.php');
die;