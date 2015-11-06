<?php

namespace spec\JOR;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
        $this->rollMany($this, [4, 5, 6]);
        $this->getFrame(1)->getFirstRoll()->numberOfPins()->shouldReturn(4);
        $this->getFrame(1)->getSecondRoll()->numberOfPins()->shouldReturn(5);
        $this->getFrame(2)->getFirstRoll()->numberOfPins()->shouldReturn(6);
    }

    function it_accepts_the_maximum_number_of_rolls()
    {
        $this->rollPerfect($this);
        $this->getFrame(1)->getFirstRoll()->numberOfPins()->shouldReturn(10);
        $this->getFrame(10)->getThirdRoll()->numberOfPins()->shouldReturn(10);
    }

    function it_does_not_accept_too_many_rolls()
    {
        $this->rollPerfect($this);

        $this->shouldThrow('JOR\TooManyFrames')->duringRoll(1);
    }

    function it_knows_when_its_not_completed()
    {
        $this->rollMany($this, [1, 1, 2, 2, 3, 3, 4, 4, 5, 5]);
        $this->shouldNotBeCompleted();
    }

    function it_knows_when_its_completed_after_a_gutter_game()
    {
        $this->rollGutter($this);
        $this->shouldBeCompleted();
    }

    function it_knows_when_its_completed_after_a_perfect_game()
    {
        $this->rollPerfect($this);
        $this->shouldBeCompleted();
    }

    function it_calculates_a_gutter_game()
    {
        $this->rollGutter($this);
        $this->score()->shouldReturn(0);
    }

    function it_calculates_a_game_without_strikes_or_spares()
    {
        $pins = [
            0,
            1, // 1
            1,
            2, // 3
            2,
            3, // 5
            3,
            4, // 7
            4,
            5, // 9
            5,
            4, // 9
            4,
            3, // 7
            3,
            2, // 5
            2,
            1, // 3
            1,
            0, // 1
        ];
        $this->rollMany($this, $pins);
        $this->score()->shouldReturn(50);
    }

    function it_calculates_one_spare()
    {
        $this->rollSpare($this);
        $this->roll(3);
        $this->score()->shouldReturn(16);
    }

    function it_calculates_one_strike()
    {
        $this->rollStrike($this);
        $this->roll(3);
        $this->roll(4);
        $this->score()->shouldReturn(24);
    }

    function it_calculates_two_strikes()
    {
        $this->rollStrike($this);
        $this->rollStrike($this);
        $this->roll(3);
        $this->roll(4);
        $this->score()->shouldReturn(47);
    }


    function it_calculates_a_perfect_game()
    {
        $this->rollPerfect($this);
        $this->score()->shouldReturn(300);

        $game = $this->getWrappedObject();
    }

    function rollSpare($subject)
    {
        $this->rollMany($subject, [5, 5]);
    }

    function rollStrike($subject)
    {
        $this->rollMany($subject, [10]);
    }

    function rollGutter($subject)
    {
        $this->rollMany($subject, [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
    }

    function rollPerfect($subject)
    {
        $this->rollMany($subject, [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]);
    }

    function rollMany($subject, $pinList)
    {
        foreach ($pinList as $pins) {
            $subject->roll($pins);
        }
    }

}
