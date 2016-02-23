<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;
use TextTransformer\Model\Word;

/**
 * Class Swap
 *
 * Description:
 * Soort 2: Verwissel ieder derde woord om met zijn voorganger en schrijf deze achterstevoren, waarbij eventuele
 * hoofdletters op dezelfde positie blijven.
 * @package TextTransformer\Strategy
 */
class Swap implements TransformStrategyInterface
{
    /**
     * Default steps of skipped words.
     */
    const DEFAULT_WORD_STEPS = 3;

    /**
     * Step number of words that are skipped in text.
     * @var int
     */
    protected $wordSteps;

    /**
     * Swap constructor.
     * @param int $wordSteps
     */
    public function __construct($wordSteps = self::DEFAULT_WORD_STEPS)
    {
        $this->wordSteps = $wordSteps;
    }

    /**
     * Function to transform text that satisfies the class description.
     * @param Text $text
     * @return string
     */
    public function transform(Text $text): string
    {
        $text->setWordsByText($text->getText());

        /** @var Word $word */
        $words = $text->getWords();
        foreach ($words as $key => &$word) {
            # Skip numeric words
            if ($word->isNumeric()) {
                continue;
            }
            # Every X Steps do something :)
            if (($key + 1) % $this->wordSteps == 0) {

                /** @var Word $prevWord */
                $prevWord = $text->getWords()[$key - 1];

                # When punctuation is found, swap it!
                if(count($prevWord->getChars()) > 1) {
                    $prevWordPunctuations = $prevWord->findPunctuations();
                    if (count($prevWordPunctuations[0])) {
                        $this->swapPunctuations($prevWord, $word);
                    }
                }

                # When punctuation is found, swap it!
                if(count($word->getChars()) > 1) {
                    $wordPunctuations = $word->findPunctuations();
                    if (count($wordPunctuations[0])) {
                        $this->swapPunctuations($word, $prevWord);
                    }
                }

                # Find all capitals and lower string
                $word->findCapitalPositions();

                # Reverse the word
                $word->reverse();

                # Lower the string
                $word->toLowerCase();

                # Reset capitals on the old positions
                $word->setCapitals();

                # Swap previous word with current
                $words[$key - 1] = $word;
                $words[$key] = $prevWord;
            }
        }
        $text->setWords($words);
        return $text->buildTextFromWords();
    }

    /**
     * Swaps punctuation on beginning or end of words to the target word.
     * @param Word $word
     * @param Word $targetWord
     */
    private function swapPunctuations(Word $word, Word $targetWord)
    {
        $punctuations = $word->getPunctuations();
        $wordChars = $word->getChars();
        $targetWordChars = $targetWord->getChars();

        foreach($punctuations[0] as $punctuation) {
            $position = $punctuation[1];

            if($wordChars[$position] === reset($wordChars)) {
                array_unshift($targetWordChars, reset($wordChars));
                $word->removeFirstChar();
            }

            if($wordChars[$position] === end($wordChars)) {
                array_push($targetWordChars, end($wordChars));
                $word->removeLastChar();
            }
        }
        $targetWord->setChars($targetWordChars);
    }
}