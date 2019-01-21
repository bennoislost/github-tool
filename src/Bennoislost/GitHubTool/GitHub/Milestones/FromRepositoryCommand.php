<?php

namespace Bennoislost\GitHubTool\GitHub\Milestones;

use Bennoislost\GitHubTool\GitHub\ApiServiceProvider;
use Bennoislost\GitHubTool\GitHub\CommandTraits\OrganizationInputArgumentTrait;
use Bennoislost\GitHubTool\GitHub\CommandTraits\RepositoryInputArgumentTrait;
use Cake\Collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FromRepositoryCommand extends Command
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
            ->setName('milestones')
            ->setDescription('Get milestones from a Repository');

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $milestones = $this->apiServiceProvider->milestones(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input)
        );

        $collection = (new Collection($milestones))->map(function($value, $key) {
            return [
                'number'      => $value['number'],
                'title'       => $value['title'],
                'description' => $value['description'],
                'state'       => $value['state']
            ];
        });

        (new Table($output))
            ->setHeaders(['Number', 'Title', 'Description', 'State'])
            ->setRows($collection->toArray())
            ->render();
    }
}
