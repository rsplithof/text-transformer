<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

/**
 * Interface TransformStrategyInterface
 *
 * Classes that implement this interface should be able to transform text.
 *
 * @package TextTransformer\Strategy
 */
interface TransformStrategyInterface
{
    /**
     * Function to transform text that satisfies the class description.
     * @param Text $text
     * @return string
     */
    function transform(Text $text): string;
}