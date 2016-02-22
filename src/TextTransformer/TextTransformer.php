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
     * @param string $text
     * @param TransformStrategyInterface $transformStrategy
     * @return string
     */
    public function transform(string $text, TransformStrategyInterface $transformStrategy): string
    {
        $text = new Text($text);
        return $transformStrategy->transform($text);
    }
}