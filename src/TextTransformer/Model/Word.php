<?php
namespace TextTransformer\Model;

/**
 * Class Word
 * This class is representing a word and provides handy functions to manipulate itself.
 *
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
    protected $punctuations = null;

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
     * Set chars by a given word string.
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
     * Reverse all characters.
     * @return array
     */
    public function reverse(): array
    {
        $this->chars = array_reverse($this->chars);
        return $this->chars;
    }

    /**
     * Lower all characters.
     * @return Word
     */
    public function toLowerCase()
    {
        foreach ($this->chars as &$char) {
            $char = strtolower($char);
        }
    }

    /**
     * Check if the word is numeric, including amounts of money for euro's.
     * @return bool
     */
    public function isNumeric(): bool
    {
        if (!$this->isNumeric === null) {
            return $this->isNumeric;
        }

        $word = $this->getWord();
        if (is_numeric($word) || mb_substr($word, 0, 1) === '€') {
            return $this->isNumeric = true;
        }
        return $this->isNumeric = false;
    }

    /**
     * Find all capitals in word.
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
     * Set all capitals by capitalPositions or given positions.
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
     * @param $punctuations
     */
    public function setPunctuations($punctuations)
    {
        $this->punctuations = $punctuations;
    }

    /**
     * @return array|null
     */
    public function getPunctuations()
    {
        return $this->punctuations;
    }


    /**
     * Find all punctuation and store them in $this->punctuations for later use.
     * @return array
     */
    public function findPunctuations(): array
    {
        if ($this->punctuations === null) {
            preg_match_all("/[[:punct:]]/", $this->getWord(), $this->punctuations, PREG_OFFSET_CAPTURE);
            $this->punctuations[0] = array_reverse($this->punctuations[0]);
        }
        return $this->punctuations;
    }

    /**
     * Removes all punctuations from this word.
     */
    public function removePunctuations()
    {
        $word = $this->getWord();
        $strippedWord = preg_replace("/[[:punct:]]/", '', $word);
        $this->setCharsByWord($strippedWord);
    }

    /**
     * Reset's stripped punctuations on the correct positions.
     */
    public function resetPunctuations()
    {
        if($this->punctuations !== null) {
            foreach ($this->punctuations[0] as $punctuation) {
                $char = $punctuation[0];
                $position = $punctuation[1];

                array_splice($this->chars, $position, 0, $char);
            }
        }
    }

    /**
     * Shuffle an array, in this case of characters. This function does not work when all chars are the same, because
     * that would trigger an infinite loop. Sometimes shuffle does not alter the array, so keep shuffling until the
     * output is different from the input.
     * @return array
     */
    public function shuffleChars(): array
    {
        if (count($this->chars) > 1  && count(array_unique($this->chars)) > 1) {
            $shuffledChars = $this->chars;
            while (true) {
                shuffle($shuffledChars);
                if ($shuffledChars !== $this->chars) {
                    $this->chars = $shuffledChars;
                    break;
                }
            }
        }
        return $this->chars;
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

    /**
     * Add character to the front of the word.
     * @param $char
     */
    public function addCharToFront($char)
    {
        array_unshift($this->chars, $char);
    }

    /**
     * Add character to the end of the word.
     * @param $char
     */
    public function addCharToEnd($char)
    {
        array_push($this->chars, $char);
    }
}