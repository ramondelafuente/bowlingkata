<?php

namespace spec\JOR;

use JOR\Roll;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FrameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JOR\Frame');
    }

    function it_has_no_rolls_when_emtpy()
    {
        $this->getFirstRoll()->shouldReturn(null);
        $this->getSecondRoll()->shouldReturn(null);
    }

    function it_accepts_a_roll()
    {
        $roll = new Roll(1);
        $this->addRoll($roll);
        $this->getFirstRoll()->shouldReturn($roll);
    }

    function it_accepts_a_second_roll()
    {
        $this->addRoll(new Roll(1));

        $roll = new Roll(4);
        $this->addRoll($roll);
        $this->getSecondRoll()->shouldReturn($roll);
    }

    function it_does_not_accept_too_many_rolls()
    {
        $this->addRoll(new Roll(1));
        $this->addRoll(new Roll(4));

        $roll = new Roll(6);
        $this->shouldThrow('JOR\TooManyRolls')->duringAddRoll($roll);
    }

    function it_does_not_accept_another_roll_after_strike()
    {
        $this->addRoll(new Roll(10));

        $roll = new Roll(5);
        $this->shouldThrow('JOR\TooManyPins')->duringAddRoll($roll);
    }

    function it_does_not_accept_more_than_ten_total_pins()
    {
        $this->addRoll(new Roll(6));

        $roll = new Roll(5);
        $this->shouldThrow('JOR\TooManyPins')->duringAddRoll($roll);
    }

    function it_knows_when_its_not_completed()
    {
        $this->shouldNotBeCompleted();
    }

    function it_knows_when_its_completed_with_no_more_rolls_left()
    {
        $this->addRoll(new Roll(3));
        $this->addRoll(new Roll(3));
        $this->shouldBeCompleted();
    }

    function it_knows_when_its_completed_with_a_strike()
    {
        $this->addRoll(new Roll(10));
        $this->shouldBeCompleted();
    }

    function it_calculates_its_pincount_on_empty()
    {
        $this->pinCount()->shouldReturn(0);
    }

    function it_calculates_its_pincount_on_single_roll()
    {
        $roll = new Roll(10);

        $this->addRoll($roll);
        $this->pinCount()->shouldReturn($roll->numberOfPins());
    }

    function it_calculates_its_pincount_on_double_roll()
    {
        $roll1 = new Roll(3);
        $roll2 = new Roll(4);

        $this->addRoll($roll1);
        $this->addRoll($roll2);
        $this->pinCount()->shouldReturn($roll1->numberOfPins() + $roll2->numberOfPins());
    }

    function it_knows_when_its_a_strike()
    {
        $this->addRoll(new Roll(10));
        $this->shouldBeStrike();
    }

    function it_knows_when_its_not_a_strike()
    {
        $this->addRoll(new Roll(4));
        $this->shouldNotBeStrike();

        $this->addRoll(new Roll(6));
        $this->shouldNotBeStrike();
    }

    function it_knows_when_its_a_spare()
    {
        $this->addRoll(new Roll(4));
        $this->addRoll(new Roll(6));
        $this->shouldBeSpare();
    }

}
