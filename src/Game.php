<?php

namespace JOR;

class Game
{
    /**
     * @var Frame[]
     */
    private $frames = [];
    private $currentFrame = 1;

    public function __construct() {
        for ($i=1; $i<=10; $i++) {
            $this->frames[$i] = new Frame();
        }
    }

    public function roll($pins)
    {
        $roll = new Roll($pins);
        $this->getCurrentFrame()->addRoll($roll);

        if ($this->getCurrentFrame()->isCompleted()) {
            $this->currentFrame++;
        }
    }

    public function getFrame($frameIndex)
    {
        return $this->frames[$frameIndex];
    }

    /**
     * @return Frame
     */
    public function getCurrentFrame()
    {
        return $this->frames[$this->currentFrame];
    }
}
