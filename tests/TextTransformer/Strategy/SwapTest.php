<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

class SwapTest extends \PHPUnit_Framework_TestCase
{

    public function testTransform()
    {
        $textInput = 'Wij doen iets goed of wij doen het niet. Wij besparen niet op onze service, apparatuur en faciliteiten.';
        $expectedText = 'Wij stei doen goed jiw of doen tein het. Wij tein besparen op ecivres onze, apparatuur netietilicaf en.';

        $text = new Text($textInput);
        $asciiStrategy = new Swap();

        $actualText = $asciiStrategy->transform($text);

        $this->assertEquals($expectedText, $actualText);
    }
}
