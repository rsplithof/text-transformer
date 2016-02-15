<?php
namespace Rsplithof\TextTransformer\Strategy;

/**
 * Class SmallWordsReverse
 *
 * Description:
 * Soort 1: Vervang ieder woord van 1 t/m 3 letters, door hetzelfde woord maar dan achterstevoren geschreven waarbij de
 * hoofdletters op dezelfde positie blijven. ‘Wij’ wordt dus ‘Jiw’.
 *
 * @package Rsplithof\TextTransformer\Strategy
 */
class SmallWordsReverse implements TransformStrategyInterface
{

    /**
     * @param string $text
     * @return string
     */
    public function transform(string $text): string
    {
        $words = explode(' ', $text);

        foreach($words as $key => &$word) {
            # Catch strings smaller than 4 and not numeric
            if(strlen($word) <= 3 && !is_numeric($word)) {
                $word = strtolower($word);

                # Find all capitals
                preg_match_all('/[A-Z]/', $word, $capitalMatches, PREG_OFFSET_CAPTURE);

                # Build letter array and reverse it
                $letters = array_reverse(preg_split("//u", $word, -1, PREG_SPLIT_NO_EMPTY));

                # Set capitals on same position as before it was reversed
                foreach($capitalMatches[0] as $capitalMatch) {
                    $position = $capitalMatch[1];
                    $letters[$position] = strtoupper($letters[$position]);
                }
                $word = implode('', $letters);
            }
        }

        $output = implode(' ', $words);
        return $output;
    }
}