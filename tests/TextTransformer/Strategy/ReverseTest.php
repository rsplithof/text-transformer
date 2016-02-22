<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

class ReverseTest extends \PHPUnit_Framework_TestCase
{

    public function testTransform()
    {
        $textInput = 'Wij doen iets goed of wij doen het niet. Wij besparen niet op onze service, apparatuur en faciliteiten.';
        $expectedText = 'Jiw doen iets goed fo jiw doen teh niet. Jiw besparen niet po onze service, apparatuur ne faciliteiten.';

        $text = new Text($textInput);
        $asciiStrategy = new Reverse();

        $actualText = $asciiStrategy->transform($text);

        $this->assertEquals($expectedText, $actualText);
    }
}
