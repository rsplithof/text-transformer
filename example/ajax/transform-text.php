<?php
use TextTransformer\TextTransformer;

require '../../vendor/autoload.php';

$strategy = 'TextTransformer\\Strategy\\' .  $_POST['strategy'];
$text = $_POST['text'];

$textTransformer = new TextTransformer();
echo $textTransformer->transform($text, new $strategy());
