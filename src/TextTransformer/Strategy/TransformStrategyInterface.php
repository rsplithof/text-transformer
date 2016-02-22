<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

/**
 * Interface TransformStrategyInterface
 * @package TextTransformer\Strategy
 */
interface TransformStrategyInterface
{
    /**
     * @param Text $text
     * @return string
     */
    function transform(Text $text): string;
}