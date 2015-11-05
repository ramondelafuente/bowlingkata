<?php

namespace JOR;

class Roll
{
    private $pins;

    public function __construct($pinsKnockedDown)
    {
        if ($pinsKnockedDown < 0 || $pinsKnockedDown > 10) {
            throw new InvalidNumberOfPins("InvalidNumberOfPins");
        }

        $this->pins = $pinsKnockedDown;
    }

    public function numberOfPins()
    {
        return $this->pins;
    }
}
