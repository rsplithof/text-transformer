<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;
use TextTransformer\Model\Word;

/**
 * Class Shuffle
 *
 * Soort 3: Onderzoek heeft uitgewezen dat de volgorde van letters in een woord niet heel erg belangrijk is voor de
 * leesbaarheid. Zolang de eerste en de laatste letter van een woord op hun plaats staan, maakt de volgorde van de
 * overige letters weinig uit. Zorg ervoor dat de het script instaat is om input zoals bovenstaande tekst om te zetten
 * volgens dit principe. De volgorde van de letters tussen de eerste en laatste letter mag random zijn.
 *
 * @package TextTransformer\Strategy
 */
class Shuffle implements TransformStrategyInterface
{
    /**
     * Function to transform text that satisfies the class description.
     * @param Text $text
     * @return string
     */
    public function transform(Text $text): string
    {
        $text->setWordsByText($text->getText());

        $words = $text->getWords();
        /** @var Word $word */
        foreach ($words as &$word) {
            # Catch words not numeric
            if ($word->isNumeric()) {
                continue;
            }

            # First find punctuations so they are stored
            $word->findPunctuations();

            # Remove punctuations
            $word->removePunctuations();

            # Store and remove first and last char
            $wordChars = $word->getChars();
            $firstChar = reset($wordChars);
            $lastChar = end($wordChars);

            $word->removeFirstChar();
            $word->removeLastChar();

            # Shuffle the chars that are left
            $word->shuffleChars();

            # Add first and last char
            $word->addCharToFront($firstChar);
            $word->addCharToEnd($lastChar);

            # Reset stripped punctuations
            $word->resetPunctuations();
        }
        $text->setWords($words);
        return $text->buildTextFromWords();
    }
}