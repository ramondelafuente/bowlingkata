<?php

namespace JOR;

class Game
{
    private $frames = [];

    public function __construct() {
        for ($i=1; $i<=10; $i++) {
            $this->frames[$i] = new Frame();
        }
    }

    public function roll($pins)
    {
        // TODO: write logic here
    }

    public function getFrame($frameIndex)
    {
        return $this->frames[$frameIndex];
    }
}
