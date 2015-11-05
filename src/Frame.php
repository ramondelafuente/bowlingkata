<?php

namespace JOR;

class Frame
{
    private $firstRoll;
    private $secondRoll;

    function __construct()
    {

    }

    public function getFirstRoll()
    {
        return $this->firstRoll;
    }

    public function getSecondRoll()
    {
        return $this->secondRoll;
    }

    public function addRoll(Roll $roll)
    {
        if (!is_null($this->firstRoll) && !is_null($this->secondRoll)) {
            throw new TooManyRolls("Too Many Rolls");
        }

        if ($this->firstRoll && $this->firstRoll->numberOfPins() + $roll->numberOfPins() > 10) {
            throw new TooManyPins("Too Many Pins");
        }

        if(is_null($this->firstRoll)) {
            $this->firstRoll = $roll;
        } else {
            $this->secondRoll = $roll;
        }
    }
}
