<?php

namespace Bennoislost\GitHubTool\GitHub;

use Github\Client;

class ClientFactory
{
    /**
     * @param Token $token
     *
     * @return Client
     */
    public static function create(Token $token)
    {
        $client = new Client;

        $client->authenticate($token->asString(), '', Client::AUTH_HTTP_TOKEN);

        return $client;
    }
}
