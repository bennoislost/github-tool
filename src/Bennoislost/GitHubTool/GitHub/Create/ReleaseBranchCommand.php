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

class ReleaseBranchCommand extends Command
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
            ->setName('create:release-branch')
            ->setDescription('Create a release branch for a Repository');

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
        $this->addArgument('branch_name', InputArgument::REQUIRED, 'Release branch name to create');
        $this->addArgument('reference_branch', InputArgument::REQUIRED, 'Reference branch to use (master)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $referenceBranch = "heads/" . $input->getArgument('reference_branch');

        $reference = $this->apiServiceProvider->reference(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input),
            $referenceBranch
        );

        $releaseReference = $this->apiServiceProvider->createReference(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input),
            "refs/heads/" . $input->getArgument('branch_name'),
            $reference['object']['sha']
        );

        $output->writeln(sprintf(
            'Branch created "%s" (%s)',
            $input->getArgument('branch_name'),
            $releaseReference['object']['sha']
        ));
    }
}
