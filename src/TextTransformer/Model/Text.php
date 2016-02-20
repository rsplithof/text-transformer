<?php
namespace TextTransformer\Model;

class Text
{
    protected $words = [];

    public function __construct(string $text)
    {
        $this->setWords($text);
    }

    protected function setWords(string $text)
    {
        $words = explode(" ",$text);
        foreach($words as $word) {
            $this->words[] = new Word($word);
        }
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function getText(): string
    {
        $words = [];
        foreach($this->words as $word) {
            $words[] = $word->getWord();;
        }
        return implode(" ", $words);
    }
}