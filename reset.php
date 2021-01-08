<?php
session_start();

foreach (['states','is_playing','row_revealed','column_revealed','feedback'] as $keyToUnset){
    unset($_SESSION[$keyToUnset]);
}

header('Location: index.php');
die;