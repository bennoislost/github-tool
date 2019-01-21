<?php

namespace spec\Bennoislost\GitHubTool\GitHub;

use Bennoislost\GitHubTool\GitHub\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositorySpec extends ObjectBehavior
{
    const REPO = 'some-repo-name';

    function it_is_initializable()
    {
        $this->shouldHaveType(Repository::class);
    }

    function it_should_have_repository_value()
    {
        $this->beConstructedFromRepositoryString(self::REPO);
        $this->asString()->shouldBe(self::REPO);
    }
}
