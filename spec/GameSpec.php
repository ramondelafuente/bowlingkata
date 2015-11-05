<?php

namespace spec\JOR;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use JOR\Frame;
use JOR\Roll;

class GameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JOR\Game');
        $this->getFrame(1)->shouldReturnAnInstanceOf('JOR\Frame');
        $this->getFrame(2)->shouldReturnAnInstanceOf('JOR\Frame');
        $this->getFrame(10)->shouldReturnAnInstanceOf('JOR\Frame');
    }

    function it_returns_the_first_frame_as_current_when_empty()
    {
        $this->getCurrentFrame()->shouldReturn($this->getFrame(1));
    }

    function it_accepts_a_roll()
    {
        $this->roll(4);
        $this->getFrame(1)->getFirstRoll()->numberOfPins()->shouldReturn(4);
    }

    function it_accepts_multiple_rolls()
    {
        $this->rollMany($this, [4,5,6]);
        $this->getFrame(1)->getFirstRoll()->numberOfPins()->shouldReturn(4);
        $this->getFrame(1)->getSecondRoll()->numberOfPins()->shouldReturn(5);
        $this->getFrame(2)->getFirstRoll()->numberOfPins()->shouldReturn(6);
    }

    function rollMany($subject, $pinList)
    {
        foreach ($pinList as $pins) {
            $subject->roll($pins);
        }
    }

}
