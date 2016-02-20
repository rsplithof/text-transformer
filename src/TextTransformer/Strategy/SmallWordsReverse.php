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
class SmallWordsReverse implements TransformStrategyInterface
{

    /**
     * @param Text|string $text
     * @return Text|string
     */
    public function transform(Text $text): text
    {
        /** @var Word $word */
        foreach($text->getWords() as &$word) {

            # Catch words smaller than 4 and not numeric
            if (!$word->isNumeric() && count($word->getChars()) <= 3) {

                # Find all capitals and lower string
                $word->findCapitalPositions();

                # Reverse the word
                $word->reverse();

                # Lower the string
                $word->toLowerCase();

                # Reset capitals on the old positions
                $word->setCapitals();
            }
        }
        return $text;
    }
}