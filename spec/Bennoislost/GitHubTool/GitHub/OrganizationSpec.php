<?php

namespace spec\Bennoislost\GitHubTool\GitHub;

use Bennoislost\GitHubTool\GitHub\Organization;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrganizationSpec extends ObjectBehavior
{
    const ORGINISATION = 'bennoislost';

    function it_is_initializable()
    {
        $this->shouldHaveType(Organization::class);
    }

    function it_should_have_organization_value()
    {
        $this->beConstructedFromOrganizationString(self::ORGINISATION);
        $this->asString()->shouldBe(self::ORGINISATION);
    }
}
