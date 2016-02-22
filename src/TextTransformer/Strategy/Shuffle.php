<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;
use TextTransformer\Model\Word;

/**
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
            $wordChars = $word->getChars();

            # First find punctuations and remove them
            $punctuations = $word->findPunctuations();
            foreach ($punctuations[0] as $punctuation) {
                $position = $punctuation[1];
                unset($wordChars[$position]);
            }

            # Remove first and last char
            $firstChar = reset($wordChars);
            array_shift($wordChars);
            $lastChar = end($wordChars);
            array_pop($wordChars);

            # Shuffle chars if there are more then 1 characters left
            if (count($wordChars) > 1) {
                $wordChars = $this->shuffleChars($wordChars);
            }

            # Glue the chars back together
            array_unshift($wordChars, $firstChar);
            array_push($wordChars, $lastChar);

            # Reset punctuations
            if (count($punctuations[0])) {
                $wordChars = $this->resetPunctuations($wordChars, $punctuations);
            }

            # Set new chars on the word obj
            $word->setChars($wordChars);

        }
        $text->setWords($words);
        return $text->buildTextFromWords();
    }

    /**
     * Shuffle an array, in this case of characters. This function does not work when all chars are the same, because
     * that would trigger an infinite loop. Sometimes shuffle does not alter the array, so keep shuffling until the
     * output is different from the input.
     * @param array $chars
     * @return array
     */
    private function shuffleChars(array $chars): array
    {
        $shuffledChars = $chars;
        if (count(array_unique($chars)) > 1) {
            while (true) {
                shuffle($shuffledChars);
                if ($shuffledChars !== $chars) {
                    break;
                }
            }
        }
        return $shuffledChars;
    }

    /**
     * Reset's stripped punctuations on the correct positions.
     * @param array $chars
     * @param array $punctuations
     * @return array
     */
    private function resetPunctuations(array $chars, array $punctuations): array
    {
        foreach ($punctuations[0] as $punctuation) {
            $char = $punctuation[0];
            $position = $punctuation[1];

            array_splice($chars, $position, 0, $char);
        }
        return $chars;
    }
}