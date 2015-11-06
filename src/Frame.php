<?php

namespace JOR;

class Frame
{
    /**
     * @var Roll[]
     */
    protected $rolls = [];

    protected $maxRollCount = 2;
    protected $maxPinCount  = 10;
    protected $rollCount;

    function __construct()
    {
    }

    public function getFirstRoll()
    {
        return isset($this->rolls[0]) ? $this->rolls[0] : null;
    }

    public function getSecondRoll()
    {
        return isset($this->rolls[1]) ? $this->rolls[1] : null;
    }

    public function addRoll(Roll $roll)
    {
        if ($this->rollCount === $this->maxRollCount) {
            throw new TooManyRolls("Too Many Rolls");
        }

        if ($this->pinCount() + $roll->numberOfPins() > $this->maxPinCount) {
            throw new TooManyPins("Too Many Pins");
        }

        $this->rolls[] = $roll;
        $this->rollCount++;
    }

    public function isCompleted()
    {
        if ($this->rollCount === $this->maxRollCount) {
            return true;
        }

        if ($this->pinCount() === $this->maxPinCount) {
            return true;
        }

        return false;
    }

    public function pinCount()
    {
        $pinCount = 0;
        foreach ($this->rolls as $roll) {
            $pinCount += $roll->numberOfPins();
        }

        return $pinCount;
    }

    public function isStrike()
    {
        return $this->getFirstRoll() && $this->getFirstRoll()->numberOfPins() === 10;
    }

    public function isSpare()
    {
        if (!$this->isStrike() && $this->getFirstRoll() && $this->getSecondRoll()) {
            return $this->getFirstRoll()->numberOfPins() + $this->getSecondRoll()->numberOfPins() === 10;
        }

        return false;
    }

    public function __toString()
    {
        if ($this->isStrike()) {
            return 'X. ';
        }
        if ($this->isSpare()) {
            return $this->getFirstRoll()->numberOfPins() . './';
        }
        if ($this->getFirstRoll()) {
            $result = $this->getFirstRoll()->numberOfPins();
        }
        if ($this->getSecondRoll()) {
            $result .= '.' . $this->getSecondRoll()->numberOfPins();
        }
        return $result;
    }

}
