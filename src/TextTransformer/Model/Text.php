<?php
namespace TextTransformer\Model;

/**
 * Class Text representing a given text. Text contains word which can be manipulated.
 * @package TextTransformer\Model
 */
class Text
{
    /**
     * @var array
     */
    protected $words = [];

    /**
     * Text constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->setWordsByText($text);
    }

    /**
     * Builds an array of Word objects
     * @param string $text
     */
    protected function setWordsByText(string $text)
    {
        $words = explode(" ",$text);
        foreach($words as $word) {
            $this->words[] = new Word($word);
        }
    }

    /**
     * @return array
     */
    public function getWords(): array
    {
        return $this->words;
    }


    /**
     * @param array $words
     */
    public function setWords(array $words)
    {
        $this->words = $words;
    }


    /**
     * Glue all words together to make a text
     * @return string
     */
    public function getText(): string
    {
        $words = [];
        foreach($this->words as $word) {
            $words[] = $word->getWord();;
        }
        return implode(" ", $words);
    }
}