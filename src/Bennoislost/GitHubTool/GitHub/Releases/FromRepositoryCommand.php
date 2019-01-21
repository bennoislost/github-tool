<?php

namespace Bennoislost\GitHubTool\GitHub\Releases;

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
            ->setName('releases')
            ->setDescription("Get releases from a Repository");

        $this->setOrganisationArgument();
        $this->setRepositoryArgument();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $releases = $this->apiServiceProvider->releases(
            $this->getOrganizationInput($input),
            $this->getRepositoryInput($input)
        );

        $collection = (new Collection($releases))->map(function($value, $key) {
            return [
                'name'         => $value['name'],
                'tag'          => $value['tag_name'],
                'created_at'   => (new \DateTimeImmutable($value['created_at']))->format('d-m-Y h:i'),
                'published_at' => (new \DateTimeImmutable($value['published_at']))->format('d-m-Y h:i'),
                'draft'        => ($value['draft']) ? "<fg=red>Yes</>" : "<info>No</info>"
            ];
        });

        (new Table($output))
            ->setHeaders(['Name', 'Tag', 'Created', 'Published', 'Draft'])
            ->setRows($collection->toArray())
            ->render();
    }
}
