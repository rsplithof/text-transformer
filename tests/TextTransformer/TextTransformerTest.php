<?php
namespace TextTransformer;

class TextTransformerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerTestTransform
     * @param string $strategyClassName
     * @param string $inputText
     * @param string $expectedText
     */
    public function testTransform(string $strategyClassName, string $inputText, string $expectedText )
    {
        $textTransformer = new TextTransformer();

        $strategyNamespace = 'TextTransformer\\Strategy\\' . $strategyClassName;
        $strategyClass = new $strategyNamespace();

        $actualText = $textTransformer->transform($inputText, $strategyClass);

        $this->assertEquals($expectedText, $actualText);
    }


    public function providerTestTransform()
    {
        $text = 'Wij doen iets goed of wij doen het niet. Wij .besparen niet op .onze service, apparatuur en faciliteiten. €100 frikandél (speciaal)';

        return array(
            array(
                'ASCII',
                $text,
                'Whi!cnfm!hfst!fnfe!ng!vji!cnfm!gfs!mjfs/!Vhi!-adrqbqfm!mjfs!no!-noyf!rfqujdd-!`opbqbstus!dm!ebbhkjsfhsfm/!₫210!eqjjbmeèm!\'rqfdhbak*',
            ),
            array(
                'Reverse',
                $text,
                'Jiw doen iets goed fo jiw doen teh niet. Jiw .besparen niet po .onze service, apparatuur ne faciliteiten. €100 frikandél (speciaal)',
            ),
            array(
                'Shuffle',
                'Wij doen iets goed of wij doen het niet. 100 (séac)',
                'Wij deon ites geod of wij deon het neit. 100 (saéc)',
            ),
            array(
                'Swap',
                $text,
                'Wij stei doen goed jiw of doen tein het. Wij tein .besparen op ecivres .onze, apparatuur netietilicaf en. €100 laaiceps (frikandél)',
            )
        );
    }
}
