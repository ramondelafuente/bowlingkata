<?php

namespace JOR;

class Game
{
    /**
     * @var Frame[]
     */
    private $frames = [];
    private $maxFrames = 10;
    private $currentFrame = 1;

    public function __construct()
    {
        for ($i = 1; $i < $this->maxFrames; $i++) {
            $this->frames[$i] = new Frame();
        }
        $this->frames[$this->maxFrames] = new TenthFrame();
    }

    public function roll($pins)
    {
        if ($this->getCurrentFrame()->isCompleted()) {
            if ($this->maxFrames === $this->currentFrame) {
                throw new TooManyFrames(sprintf('The game is completed after %s Frames, no more rolls allowed',
                    $this->maxFrames));
            }
            $this->currentFrame++;
        }

        $roll = new Roll($pins);
        $this->getCurrentFrame()->addRoll($roll);
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

    public function score()
    {
        return array_sum($this->getFrameScores());
    }

    private function getFrameScores()
    {
        $frameScores = [];
        for ($i = 1; $i <= 10; $i++) {
            $thisFrame = $this->frames[$i];

            $frameScores[$i] = $this->frames[$i]->pinCount();

            if (isset($this->frames[$i - 1])) {
                $oneFrameAgo = $this->frames[$i - 1];

                if ($oneFrameAgo->isStrike()) {
                    $frameScores[$i - 1] += ($i === 10 ? 20 : $thisFrame->pinCount());
                }
                if ($this->frames[$i - 1]->isSpare()) {
                    $frameScores[$i - 1] += $thisFrame->getFirstRoll()->numberOfPins();
                }

                if (isset($this->frames[$i - 2])) {
                    $twoFramesAgo = $this->frames[$i - 2];

                    if ($twoFramesAgo->isStrike() && $oneFrameAgo->isStrike()) {
                        $frameScores[$i - 2] += $thisFrame->getFirstRoll()->numberOfPins();
                    }
                }
            }

        }

        return $frameScores;
    }

    public function isCompleted()
    {
        if ($this->maxFrames === $this->currentFrame && $this->getCurrentFrame()->isCompleted()) {
            return true;
        }

        return false;
    }

    public function __toString()
    {
        $result = "|---------------------------------------|\n|";
        foreach($this->frames as $frame) {
            $result .= $frame . '|';
        }
        $result .= "\n|";
        foreach($this->getFrameScores() as $score) {
            $result .= str_pad($score,3) . '|';
        }
        $result .= "\n|---------------------------------------|\n";

        $result .= "Score: " . $this->score() . "\n";

        return $result;

    }
}
