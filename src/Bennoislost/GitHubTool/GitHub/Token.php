<?php

namespace Bennoislost\GitHubTool\GitHub;

class Token
{
    private function __construct($token)
    {
        $this->token = $token;
    }

    public static function fromTokenString($token)
    {
        return new self($token);
    }

    public function asString()
    {
        return (string)$this->token;
    }
}
