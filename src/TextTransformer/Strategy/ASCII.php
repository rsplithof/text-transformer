<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

/**
 * Soort 4: In deze tekst willen we karakters vervangen op basis van zijn voorganger. Ieder karakter heeft een waarde in
 * de ASCII tabel. Is de waarde van zijn voorganger groter, vervang dan het karakter met het volgende karakter volgens
 * de ASCII tabel, is deze kleiner, vervang dan het karakter met het vorige karakter volgens de ASCII tabel. Is de
 * waarde identiek, doe dan niks. Het eerste karakter heeft geen voorganger dus, ook deze kun je laten zoals het is.
 *
 * @package TextTransformer\Strategy
 */
class ASCII implements TransformStrategyInterface
{
    /**
     * @param Text $text
     * @return string
     */
    public function transform(Text $text): string
    {
        $chars = $text->getCharsByText();
        $asciiChars = [];

        foreach ($chars as $key => $char) {
            $asciiChars[$key] = $this->uni_ord($char);

            # Skip first char, has no predecessor
            if ($key == 0) {
                continue;
            }

            # Greater then predecessor
            if ($asciiChars[$key] < $asciiChars[$key - 1]) {
                $nextAsciiChar = $this->uni_chr($asciiChars[$key] + 1);
                $chars[$key] = $nextAsciiChar;
            }
            # Smaller then predecessor
            if ($asciiChars[$key] > $asciiChars[$key - 1]) {
                $nextAsciiChar = $this->uni_chr($asciiChars[$key] + -1);
                $chars[$key] = $nextAsciiChar;
            }
        }

        $text->setChars($chars);
        return $text->buildTextFromChars();
    }

    /**
     * @param $u
     * @return int
     */
    private function uni_ord($u)
    {
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }

    /**
     * @param $u
     * @return string
     */
    private function uni_chr($u)
    {
        return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
    }

}