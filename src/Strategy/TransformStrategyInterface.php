<?php
namespace Rsplithof\TextTransformer\Strategy;


interface TransformStrategyInterface
{
    function transform(string $text): string;
}