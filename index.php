<?php
require_once 'Character.php';

$character = new Character();
$id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 1;

echo '<pre>'.print_r($character->findById($id), 1).'</pre>';