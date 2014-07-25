<?php
require_once 'CharacterFactory.php';

$factory = new CharacterFactory();
$id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 1;
$character = $factory->findById($id);

echo '<pre>'.print_r($character, 1).'</pre>';
echo '<img src="./imgs/' . $character->img . '">';