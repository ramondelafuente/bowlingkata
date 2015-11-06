<?php

namespace spec\JOR;

use JOR\Roll;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TenthFrameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JOR\TenthFrame');
    }

    function it_accepts_a_third_roll_on_strike()
    {
        $this->addRoll(new Roll(10));
        $this->addRoll(new Roll(2));

        $roll = new Roll(4);
        $this->addRoll($roll);
        $this->getThirdRoll()->shouldReturn($roll);
    }

    function it_accepts_a_third_roll_on_spare()
    {
        $this->addRoll(new Roll(4));
        $this->addRoll(new Roll(6));

        $roll = new Roll(4);
        $this->addRoll($roll);
        $this->getThirdRoll()->shouldReturn($roll);
    }

    function it_does_not_accept_too_many_rolls()
    {
        $this->addRoll(new Roll(10));
        $this->addRoll(new Roll(2));
        $this->addRoll(new Roll(3));

        $roll = new Roll(1);
        $this->shouldThrow('JOR\TooManyRolls')->duringAddRoll($roll);
    }

    function it_accepts_another_roll_after_strike()
    {
        $this->addRoll(new Roll(1));

        $roll = new Roll(5);
        $this->addRoll($roll);
        $this->getSecondRoll()->shouldReturn($roll);
    }

    function it_knows_when_its_not_completed()
    {
        // One strike
        $this->addRoll(new Roll(10));
        $this->shouldNotBeCompleted();

        // Two strikes
        $this->addRoll(new Roll(10));
        $this->shouldNotBeCompleted();
    }

    function it_knows_its_completed_with_two_gutters()
    {
        $this->addRoll(new Roll(0));
        $this->addRoll(new Roll(0));

        $this->shouldBeCompleted();
    }

    function it_knows_its_completed_with_three_strikes()
    {
        $this->addRoll(new Roll(10));
        $this->addRoll(new Roll(10));
        $this->addRoll(new Roll(10));

        $this->shouldBeCompleted();
    }

    function it_calculates_its_pincount_on_tripple_roll()
    {
        $roll1 = new Roll(3);
        $roll2 = new Roll(7);
        $roll3 = new Roll(5);

        $this->addRoll($roll1);
        $this->addRoll($roll2);
        $this->addRoll($roll3);
        $this->pinCount()->shouldReturn($roll1->numberOfPins() + $roll2->numberOfPins() + $roll3->numberOfPins());
    }

}
