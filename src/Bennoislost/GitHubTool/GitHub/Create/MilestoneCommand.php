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

class MilestoneCommand extends Command
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
            ->setName('create:milestone')
            ->setDescription('Create a Milestone for a Repository');

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
        $this->addArgument('title', InputArgument::REQUIRED, 'Milestone title');
        $this->addArgument('description', InputArgument::REQUIRED, 'Milestone description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apiServiceProvider->createMilestone(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input),
            $input->getArgument('title'),
            $input->getArgument('description')
        );

        $output->writeln(
            sprintf(
                '<info>Milestone "%s" created for %s:%s</info>',
                $input->getArgument('title'),
                $this->getOrganizationInput($input)->asString(),
                $this->getRepositoryInput($input)->asString()
            )
        );
    }
}
