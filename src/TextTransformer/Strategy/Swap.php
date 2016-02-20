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
     * Default steps of skipped words
     */
    const DEFAULT_WORD_STEPS = 3;

    /**
     * @var int Step number of words that are skipped in text
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
     * Transforms given text to an format that satisfies the description of this class
     * @param Text $text
     * @return Text
     */
    public function transform(Text $text): Text
    {
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

                # Check if prev word ends with punctuation
                $prevWordPunctuations = $prevWord->findPunctuation();
                if ($prevWordPunctuations['start'] || $prevWordPunctuations['end']) {
                    $this->swapPunctuation($prevWord, $word, $prevWordPunctuations);
                }

                # Check if current word ends with punctuation
                $wordPunctuations = $word->findPunctuation();
                if ($wordPunctuations['start'] || $wordPunctuations['end']) {
                    $this->swapPunctuation($word, $prevWord, $wordPunctuations);
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
        return $text;
    }

    /**
     * Swaps punctuation on beginning or end of words to the target word.
     * @param Word $word
     * @param Word $targetWord
     * @param array $punctuation containing an 'start' en 'end' key pointing to the position
     */
    private function swapPunctuation(Word $word, Word $targetWord, array $punctuation)
    {
        $wordChars = $word->getChars();
        $targetWordChars = $targetWord->getChars();

        # If word start with punctuation, swap it to the end of the target word
        if ($punctuation['start']) {
            array_unshift($targetWordChars, reset($wordChars));
            $word->removeFirstChar();
        }
        # If word ends with punctuation, swap it to the fron of the target word
        if ($punctuation['end']) {
            array_push($targetWordChars, end($wordChars));
            $word->removeLastChar();
        }

        $targetWord->setChars($targetWordChars);
    }
}