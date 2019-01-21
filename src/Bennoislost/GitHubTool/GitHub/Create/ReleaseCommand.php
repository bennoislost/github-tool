<?php

namespace Bennoislost\GitHubTool\GitHub\Create;

use Bennoislost\GitHubTool\GitHub\ApiServiceProvider;
use Bennoislost\GitHubTool\GitHub\CommandTraits\OrganizationInputArgumentTrait;
use Bennoislost\GitHubTool\GitHub\CommandTraits\RepositoryInputArgumentTrait;
use Cake\Collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReleaseCommand extends Command
{
    use OrganizationInputArgumentTrait;
    use RepositoryInputArgumentTrait;

    /**
     * @var ApiServiceProvider
     */
    private $apiServiceProvider;

    public function __construct(ApiServiceProvider $apiServiceProvider)
    {
        $this->apiServiceProvider = $apiServiceProvider;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('create:release')
            ->setDescription('Create a Release for a Repository');

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
        $this->addArgument('tag', InputArgument::REQUIRED, 'Release tag');
        $this->addArgument('title', InputArgument::REQUIRED, 'Release title');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $markdown = <<<MARKDOWN
## Fixes
* TASK-123: #123 - Some description

## Features
* TASK-123: #123 - Some description

## DevOps
* TASK-123: #123 - Some description

MARKDOWN;

        $this->apiServiceProvider->createRelease(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input),
            $input->getArgument('tag'),
            $input->getArgument('title'),
            $markdown
        );

        $output->writeln(
            sprintf(
                '<info>Release "%s" (%s) created for %s:%s</info>',
                $input->getArgument('tag'),
                $input->getArgument('title'),
                $this->getOrganizationInput($input)->asString(),
                $this->getRepositoryInput($input)->asString()
            )
        );
    }
}
