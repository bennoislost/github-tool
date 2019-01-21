<?php
/**
 * Created by PhpStorm.
 * User: bmcmanus
 * Date: 07/12/2018
 * Time: 13:52
 */

namespace Bennoislost\GitHubTool\GitHub;

use Github\Client as GitHubClient;

class ApiServiceProvider
{
    /**
     * @var GitHubClient
     */
    private $client;

    public function __construct(GitHubClient $client)
    {
        $this->client = $client;
    }

    public function milestones(Organization $organization, Repository $repository)
    {
        return $this->client
            ->api('issue')
            ->milestones()
            ->all(
                $organization->asString(),
                $repository->asString()
            );
    }

    public function pullRequests(Organization $organization, Repository $repository)
    {
        return $this->client
            ->api('pull_request')
            ->all(
                $organization->asString(),
                $repository->asString()
            );
    }

    public function releases(Organization $organization, Repository $repository)
    {
        return $this->client
            ->api('repo')
            ->releases()
            ->all(
                $organization->asString(),
                $repository->asString()
            );
    }


}
