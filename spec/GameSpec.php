<?php

namespace spec\JOR;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use JOR\Frame;

class GameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JOR\Game');
        $this->getFrame(1)->shouldReturnAnInstanceOf('JOR\Frame');
        $this->getFrame(2)->shouldReturnAnInstanceOf('JOR\Frame');
        $this->getFrame(10)->shouldReturnAnInstanceOf('JOR\Frame');
    }

    function it_accepts_a_roll()
    {
        $this->roll(4);
        $this->getFrame(1)->shouldReturn(new Frame());
    }
}
