<?php
session_start();

$rows = range('A','J');
$columns = range(1,10);

if(!array_key_exists('is_playing',$_SESSION)){
    $_SESSION['is_playing'] = true;
}

if(!array_key_exists('mines',$_SESSION)){
    //@todo: Make generation of mines random
    $_SESSION['mines'] = ['E3','F7','H8','J9','B8'];
}
if(!array_key_exists('states',$_SESSION)){
    $_SESSION['states'] = [];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MineSweeper</title>
    <style>
        td{
            width: 50px;
            height: 50px;
            background-color: gray;
            text-align: center;
        }
        td.clear {
            background-color: green;
        }
        td.mine {
            background-color: red;
        }
        td.flagged {
            background-color: orange;
        }
    </style>
</head>
<body>
<h4>MINE-SWEEPER</h4>
<p><?php if(array_key_exists('feedback',$_SESSION)){ echo $_SESSION['feedback'];} ?></p>
<table>
    <?php foreach ($rows as $row): ?>
        <tr>
            <?php foreach ($columns as $column): ?>
                <td id="<?php echo $row.$column; ?>"
                <?php if(array_key_exists($row.$column,$_SESSION['states'])): ?>
                    <?php if($_SESSION['states'][$row.$column] === "MINE"): ?>
                        class="mine"
                    <?php elseif($_SESSION['states'][$row.$column] === "FLAGGED"): ?>
                        class="flagged"
                    <?php else: ?>
                        class="clear"
                    <?php endif; ?>
                <?php endif; ?>
                >
                    <?php if(array_key_exists($row.$column,$_SESSION['states']) AND ($_SESSION['states'][$row.$column] !== "MINE") AND ($_SESSION['states'][$row.$column] !== "FLAGGED")){ echo $_SESSION['states'][$row.$column];} ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
<?php if($_SESSION['is_playing']): ?>
    <form action="reveal.php" method="post">
        <select name="row">
            <?php foreach ($rows as $row): ?>
                <option value="<?php echo $row; ?>" <?php if(array_key_exists('row_revealed',$_SESSION) && $_SESSION['row_revealed'] == $row): ?>selected<?php endif; ?>> <?php echo $row; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="column">
            <?php foreach ($columns as $column): ?>
                <option value="<?php echo $column; ?>" <?php if(array_key_exists('column_revealed',$_SESSION) && $_SESSION['column_revealed'] == $row): ?>selected<?php endif; ?>><?php echo $column; ?></option>
            <?php endforeach; ?>
        </select>
        <button>REVEAL!</button>
    </form>
    <form action="flag.php" method="post">
        <select name="row">
            <?php foreach ($rows as $row): ?>
                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="column">
            <?php foreach ($columns as $column): ?>
                <option value="<?php echo $column; ?>"><?php echo $column; ?></option>
            <?php endforeach; ?>
        </select>
        <button>FLAG!</button>
    </form>
<?php else: ?>
    <a href="reset.php">RESET</a>
<?php endif; ?>
</body>
</html>