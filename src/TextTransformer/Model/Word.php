<?php
namespace TextTransformer\Model;

/**
 * Class Word
 * @package TextTransformer\Model
 */
class Word
{
    /**
     * @var
     */
    protected $chars;

    /**
     * @var null
     */
    protected $isNumeric = null;

    /**
     * @var null
     */
    protected $capitalPositions = [];

    /**
     * Word constructor.
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->setChars($word);
    }

    /**
     * @param string $word
     */
    protected function setChars(string $word)
    {
        $this->chars = preg_split("//u", $word, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @return array
     */
    public function getChars(): array
    {
        return $this->chars;
    }

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
        foreach($this->chars as &$char) {
            $char = strtolower($char);
        }
    }

    /**
     * @return bool
     */
    public function isNumeric(): bool
    {
        if(!$this->isNumeric === null) {
            return $this->isNumeric;
        }

        $word = $this->getWord();
        if(is_numeric($word) || substr($word, 0, 1) === '€') {
            return $this->isNumeric = true;
        }
        return $this->isNumeric = false;
    }

    /**
     * @return array
     */
    public function findCapitalPositions(): array
    {
        foreach($this->chars as $position => $char) {
            if(ctype_upper($char)) {
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
        if($positions !== null) {
            $this->capitalPositions = $positions;
        }
        foreach($this->capitalPositions as $capitalPosition) {
            $this->chars[$capitalPosition] = strtoupper($this->chars[$capitalPosition]);
        }
    }
}