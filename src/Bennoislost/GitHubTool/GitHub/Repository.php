<?php

namespace Bennoislost\GitHubTool\GitHub;

class Repository
{
    /**
     * @var string
     */
    private $repository;

    private function __construct(string $repository)
    {
        $this->repository = $repository;
    }

    public static function fromRepositoryString(string $repository)
    {
        return new self($repository);
    }

    public function asString()
    {
        return $this->repository;
    }
}
