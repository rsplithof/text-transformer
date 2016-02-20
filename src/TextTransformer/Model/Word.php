<?php
namespace TextTransformer\Model;


/**
 * This class is representing an Word and provides handy functions to manipulate itself.
 * Class Word
 * @package TextTransformer\Model
 */
class Word
{
    /**
     * Characters of the word.
     * @var array
     */
    protected $chars = [];

    /**
     * Defines if word is numeric or not.
     * @var null|bool
     */
    protected $isNumeric = null;

    /**
     * holds the positions of capitalized characters.
     * @var array
     */
    protected $capitalPositions = [];

    /**
     * has 'start' and 'end' key with boolean value in case the word starts or end with punctuation.
     * @var null|array
     */
    protected $punctuation = null;

    /**
     * Word constructor.
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->setCharsByWord($word);
    }

    /**
     * @param array $chars
     */
    public function setChars(array $chars)
    {
        $this->chars = $chars;
    }

    /**
     * @return array this->chars
     */
    public function getChars(): array
    {
        return $this->chars;
    }

    /**
     * @param string $word
     */
    protected function setCharsByWord(string $word)
    {
        $this->chars = preg_split("//u", $word, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return implode('', $this->chars);
    }

    /**
     * @return array
     */
    public function reverse(): array
    {
        $this->chars = array_reverse($this->chars);
        return $this->chars;
    }

    /**
     * @return Word
     */
    public function toLowerCase()
    {
        foreach ($this->chars as &$char) {
            $char = strtolower($char);
        }
    }

    /**
     * Check if the word is numeric, includes amounts of money for euro's
     * @return bool
     */
    public function isNumeric(): bool
    {
        if (!$this->isNumeric === null) {
            return $this->isNumeric;
        }

        $word = $this->getWord();
        if (is_numeric($word) || substr($word, 0, 1) === '€') {
            return $this->isNumeric = true;
        }
        return $this->isNumeric = false;
    }

    /**
     * @return array
     */
    public function findCapitalPositions(): array
    {
        foreach ($this->chars as $position => $char) {
            if (ctype_upper($char)) {
                $this->capitalPositions[] = $position;
            }
        }
        return $this->capitalPositions;
    }

    /**
     * @param array|null $positions
     */
    public function setCapitals(array $positions = null)
    {
        if ($positions !== null) {
            $this->capitalPositions = $positions;
        }
        foreach ($this->capitalPositions as $capitalPosition) {
            $this->chars[$capitalPosition] = strtoupper($this->chars[$capitalPosition]);
        }
    }

    /**
     * @param $punctuation
     */
    public function setPunctuation($punctuation)
    {
        $this->punctuation = $punctuation;
    }

    /**
     * @return array
     */
    public function findPunctuation(): array
    {
        if ($this->punctuation === null) {
            $this->punctuation['start'] = preg_match("/[.!?,;:)(]/", reset($this->chars));
            $this->punctuation['end'] = preg_match("/[.!?,;:)(]/", end($this->chars));
        }
        return $this->punctuation;
    }

    /**
     * Removes last character
     */
    public function removeLastChar()
    {
        array_pop($this->chars);
    }

    /**
     * Removes first character
     */
    public function removeFirstChar()
    {
        array_shift($this->chars);
    }
}