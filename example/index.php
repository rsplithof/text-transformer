<?php
use TextTransformer\TextTransformer;
use TextTransformer\Strategy\ {
    SmallWordsReverse
};

require '../vendor/autoload.php';

$text = 'Wij doen iets goed of wij doen het niet. Wij besparen niet op onze service, apparatuur en faciliteiten. Betrouwbaarheid & snelheid staan altijd voorop. Wij nemen uw zorgen uit handen en implementeren dé beste totaaloplossing voor uw specifieke wensen gebaseerd op méér dan 10 jaar aan ervaring! Wij beheren diensten voor meer dan 1000 klanten, onder andere 12.000 domeinnamen (vanaf €9,95 per jaar) en meer dan 600 virtuele servers. Kortom, u bent bij ons in goede handen.';

echo '<h2>Normaal</h2>';
echo $text;

echo '<h2>Soort 1:</h2>';
$textTransformer = new TextTransformer();
echo $textTransformer->transform($text, new SmallWordsReverse());

/*echo '<h2>Soort 2:</h2>';
echo $textTransformer->transform($text, new ThirdWordSwapper());
