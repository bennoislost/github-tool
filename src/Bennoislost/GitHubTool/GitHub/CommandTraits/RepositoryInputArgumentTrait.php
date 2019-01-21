<?php

namespace Bennoislost\GitHubTool\GitHub\CommandTraits;

use Bennoislost\GitHubTool\GitHub\Repository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

trait RepositoryInputArgumentTrait
{
    public function getRepositoryInput(InputInterface $input)
    {
        return Repository::fromRepositoryString(
            $input->getArgument('repository')
        );
    }

    public function setRepositoryArgument()
    {
        $this->addArgument('repository', InputArgument::REQUIRED, 'GitHub repository');
    }
}