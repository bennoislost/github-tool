<?php

namespace Bennoislost\GitHubTool\GitHub;

class Organization
{
    /**
     * @var string
     */
    private $organization;

    private function __construct(string $organization)
    {
        $this->organization = $organization;
    }

    public static function fromOrganizationString(string $organization)
    {
        return new self($organization);
    }

    public function asString()
    {
        return $this->organization;
    }
}
