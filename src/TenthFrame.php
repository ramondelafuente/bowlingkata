<?php

namespace JOR;

use PhpSpec\Exception\Example\ExampleException;

class TenthFrame extends Frame
{
    protected $maxRollCount = 3;
    protected $maxPinCount  = 30;

    public function getThirdRoll()
    {
        return isset($this->rolls[2]) ? $this->rolls[2] : null;
    }

    public function addRoll(Roll $roll)
    {
        if ($this->isCompleted()) {
            throw new TooManyRolls('No third roll allowed on tenth frame without strike or spare');
        }

        parent::addRoll($roll);
    }

    public function isCompleted()
    {
        if ($this->getFirstRoll() && $this->getSecondRoll() && $this->pinCount() < 10) {
            return true;
        }

        return parent::isCompleted();
    }

    public function __toString()
    {
        if ($this->getFirstRoll()) {
            $result = ($this->getFirstRoll()->numberOfPins() === 10 ? 'X' : $this->getFirstRoll()->numberOfPins());
        }
        if ($this->getSecondRoll()) {
            $result .= '.' . ($this->getSecondRoll()->numberOfPins() === 10 ? 'X' : $this->getSecondRoll()->numberOfPins());
        }
        if ($this->getThirdRoll()) {
            $result .= '|' . ($this->getThirdRoll()->numberOfPins() === 10 ? 'X' : $this->getThirdRoll()->numberOfPins());
        }
        return $result;
    }


}
