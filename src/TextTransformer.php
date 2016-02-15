<?php
namespace Rsplithof\TextTransformer;

use Rsplithof\TextTransformer\Strategy\TransformStrategyInterface;

/**
 * Class TextTransformer
 * @package Rsplithof\TextTransformer
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
        return $transformStrategy->transform($text);
    }
}