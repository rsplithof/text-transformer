<?php
use Rsplithof\TextTransformer\TextTransformer;
use Rsplithof\TextTransformer\Strategy\ {
    SmallWordsReverse
};

require '../vendor/autoload.php';

$text = 'Wij doen iets goed of wij doen het niet. Wij besparen niet op onze service, apparatuur en faciliteiten. Betrouwbaarheid & snelheid staan altijd voorop. Wij nemen uw zorgen uit handen en implementeren dé beste totaaloplossing voor uw specifieke wensen gebaseerd op méér dan 10 jaar aan ervaring! Wij beheren diensten voor meer dan 1000 klanten, onder andere 12.000 domeinnamen (vanaf €9,95 per jaar) en meer dan 600 virtuele servers. Kortom, u bent bij ons in goede handen.';

$textTransformer = new TextTransformer();
$textTransformer->transform($text, new SmallWordsReverse());
