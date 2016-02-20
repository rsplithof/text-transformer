<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

interface TransformStrategyInterface
{
    function transform(Text $text): Text;
}