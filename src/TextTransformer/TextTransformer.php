<?php
namespace TextTransformer;

use TextTransformer\Model\Text;
use TextTransformer\Strategy\TransformStrategyInterface;

/**
 * Class TextTransformer
 * @package TextTransformer
 */
class TextTransformer
{
    /**
     *
     */
    public function __construct() {}


    /**
     * @param string $text
     * @param TransformStrategyInterface $transformStrategy
     * @return string
     */
    public function transform(string $text, TransformStrategyInterface $transformStrategy): string
    {
        $text = new Text($text);
        $transformedText = $transformStrategy->transform($text);

        return $transformedText->getText();
    }
}