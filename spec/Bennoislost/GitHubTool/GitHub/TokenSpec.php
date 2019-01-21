<?php

namespace spec\Bennoislost\GitHubTool\GitHub;

use Bennoislost\GitHubTool\GitHub\Token;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Token::class);
    }

    function it_should_have_a_value()
    {
        $this->beConstructedFromTokenString('SOME_TOKEN');
        $this->asString()->shouldBe('SOME_TOKEN');
    }
}
