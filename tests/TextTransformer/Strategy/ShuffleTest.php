<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

class ShuffleTest extends \PHPUnit_Framework_TestCase
{

    public function testTransform()
    {
        $textInput = 'Wij doen iets goed of wij doen het niet.';
        $expectedText = 'Wij deon ites geod of wij deon het neit.';

        $text = new Text($textInput);
        $asciiStrategy = new Shuffle();

        $actualText = $asciiStrategy->transform($text);

        $this->assertEquals($expectedText, $actualText);
    }
}
