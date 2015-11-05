<?php

namespace spec\JOR;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RollSpec extends ObjectBehavior
{
    function it_represents_a_roll()
    {
        $this->beConstructedWith(0);
        $this->numberOfPins()->shouldReturn(0);
    }

    function it_does_not_accept_negative_pin_counts()
    {
        $this->beConstructedWith(-1);
        $this->shouldThrow('JOR\InvalidNumberOfPins')->duringInstantiation();
    }

    function it_does_not_accept_pin_counts_bigger_then_ten()
    {
        $this->beConstructedWith(11);
        $this->shouldThrow('JOR\InvalidNumberOfPins')->duringInstantiation();
    }

    function it_does_accept_valid_pin_counts()
    {
        $this->beConstructedWith(4);
        $this->numberOfPins()->shouldReturn(4);
    }
}
