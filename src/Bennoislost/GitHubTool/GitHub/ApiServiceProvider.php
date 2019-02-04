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

    public function createMilestone(Organization $organization, Repository $repository, $title, $description)
    {
        return $this->client
            ->api('issue')
            ->milestones()
            ->create(
                $organization->asString(),
                $repository->asString(),
                [
                    'title'       => $title,
                    'description' => $description
                ]
            );

    }

    public function createRelease(
        Organization $organization,
        Repository $repository,
        $tag,
        $title,
        $body,
        $preRelease = true,
        $draft = true
    ) {
        return $this->client->api('repo')
            ->releases()
            ->create(
                $organization->asString(),
                $repository->asString(),
                [
                    'tag_name'   => $tag,
                    'name'       => $title,
                    'body'       => $body,
                    'draft'      => $draft,
                    'prerelease' => $preRelease
                ]
            );
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

    public function createReference(Organization $organization, Repository $repository, $reference, $sha)
    {
        return $this->client
            ->api('gitData')
            ->references()
            ->create(
                $organization->asString(),
                $repository->asString(),
                [
                    'ref' => $reference,
                    'sha' => $sha
                ]
            );
    }

    public function reference(Organization $organization, Repository $repository, $reference)
    {
        return $this->client
            ->api('gitData')
            ->references()
            ->show(
                $organization->asString(),
                $repository->asString(),
                $reference
            );
    }
}
