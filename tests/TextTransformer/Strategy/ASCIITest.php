<?php
namespace TextTransformer\Strategy;

use TextTransformer\Model\Text;

class ASCIITest extends \PHPUnit_Framework_TestCase
{

    public function testTransform()
    {
        $textInput = 'Wij doen iets goed of wij doen het niet. Wij besparen niet op onze service, apparatuur en faciliteiten.';
        $expectedText = 'Whi!cnfm!hfst!fnfe!ng!vji!cnfm!gfs!mjfs/!Vhi!adrqbqfm!mjfs!no!noyf!rfqujdd-!`opbqbstus!dm!ebbhkjsfhsfm/';

        $text = new Text($textInput);
        $asciiStrategy = new ASCII();

        $actualText = $asciiStrategy->transform($text);

        $this->assertEquals($expectedText, $actualText);
    }
}
