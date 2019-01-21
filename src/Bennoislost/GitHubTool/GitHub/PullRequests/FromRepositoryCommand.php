<?php

namespace Bennoislost\GitHubTool\GitHub\PullRequests;

use Bennoislost\GitHubTool\GitHub\ApiServiceProvider;
use Bennoislost\GitHubTool\GitHub\CommandTraits\OrganizationInputArgumentTrait;
use Bennoislost\GitHubTool\GitHub\CommandTraits\RepositoryInputArgumentTrait;
use Cake\Collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
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
            ->setName('prs')
            ->setDescription("Get PR's from a Repository");

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $prs = $this->apiServiceProvider->pullRequests(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input)
        );

        $collection = (new Collection($prs))->map(function($value, $key) {
            $columns = [
                $value['number'],
                $value['title'],
                $value['user']['login'],
                $value['head']['ref']
            ];

            $labelsString = '';

            if (count($value['labels']) > 0) {
                $labels = (new Collection($value['labels']))->map(function($value, $key) {
                    return $value['name'];
                })->toArray();

                $labelsString = sprintf("Labels: %s,", implode(', ', $labels));
            }

            return [
                $columns,
                new TableSeparator(),
                [new TableCell($labelsString, ['colspan' => count($columns)])],
                new TableSeparator()
            ];
        });

        $result = $collection->unfold()->toArray();
        array_pop($result);

        (new Table($output))
            ->setHeaders(['Number', 'Title', 'Author', 'Branch'])
            ->setRows($result)
            ->render();
    }
}
