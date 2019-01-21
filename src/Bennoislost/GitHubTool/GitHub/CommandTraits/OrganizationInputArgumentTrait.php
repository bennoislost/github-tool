<?php

namespace Bennoislost\GitHubTool\GitHub\CommandTraits;

use Bennoislost\GitHubTool\GitHub\Organization;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

trait OrganizationInputArgumentTrait
{
    public function getOrganizationInput(InputInterface $input)
    {
        return Organization::fromOrganizationString(
            $input->getArgument('organization')
        );
    }

    public function setOrganisationArgument()
    {
        $this->addArgument('organization', InputArgument::REQUIRED, 'GitHub organization / person');
    }
}