<?php
namespace TextTransformer\Model;

/**
 * Class Text representing a given text. Text contains word which can be manipulated.
 * @package TextTransformer\Model
 */
class Text
{
    /**
     * @var
     */
    protected $text;

    /**
     * @var array
     */
    protected $chars = [];

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
        $this->setText($text);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
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
     * @return array
     */
    public function getChars(): array
    {
        return $this->chars;
    }

    /**
     * @param array $chars
     */
    public function setChars($chars)
    {
        $this->chars = $chars;
    }

    /**
     * Glue all words together to make a text
     * @return string
     */
    public function buildTextFromWords(): string
    {
        $words = [];
        foreach ($this->words as $word) {
            $words[] = $word->getWord();
        }
        return implode(" ", $words);
    }

    /**
     * Builds an array of Word objects
     * @param string $text
     */
    public function setWordsByText(string $text)
    {
        $words = explode(" ", $text);
        foreach ($words as $word) {
            $this->words[] = new Word($word);
        }
    }

    /**
     * Build an array of all chars in text
     * @return array
     */
    public function getCharsByText(): array
    {
        if (!empty($this->text) && empty($this->chars)) {
            $this->chars = preg_split("//u", $this->text, -1, PREG_SPLIT_NO_EMPTY);
        }
        return $this->chars;
    }

    public function buildTextFromChars(): string
    {
        return implode('', $this->chars);
    }
}