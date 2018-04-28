<?php
require_once 'Classes/Game.php';

$game = new Game(20);

$game->render( $_POST['clicked_item'] );

?>