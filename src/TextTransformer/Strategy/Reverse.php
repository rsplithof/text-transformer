<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;
use TextTransformer\Model\Word;

/**
 * Class SmallWordsReverse
 *
 * Description:
 * Soort 1: Vervang ieder woord van 1 t/m 3 letters, door hetzelfde woord maar dan achterstevoren geschreven waarbij de
 * hoofdletters op dezelfde positie blijven. ‘Wij’ wordt dus ‘Jiw’.
 *
 * @package TextTransformer\Strategy
 */
class Reverse implements TransformStrategyInterface
{
    /**
     * The default maximum chars a word has to contain in order to reverse it.
     */
    const DEFAULT_MAX_CHARS = 3;

    /**
     * Maximum chars in a word in order to reverse it.
     * @var int
     */
    protected $maxCharsInWord;

    /**
     * Reverse constructor.
     * @param int $maxCharsInWord
     */
    public function __construct($maxCharsInWord = self::DEFAULT_MAX_CHARS)
    {
        $this->maxCharsInWord = $maxCharsInWord;
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
        foreach ($text->getWords() as &$word) {

            # Catch words smaller or equal to maxCharsInWord and not numeric
            if ($word->isNumeric() || count($word->getChars()) > $this->maxCharsInWord) {
                continue;
            }

            # Find all capitals and lower string
            $word->findCapitalPositions();

            # Reverse the word
            $word->reverse();

            # Lower the string
            $word->toLowerCase();

            # Reset capitals on the old positions
            $word->setCapitals();

        }
        return $text->buildTextFromWords();
    }
}