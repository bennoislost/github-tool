<?php

$container['github_token'] = \Bennoislost\GitHubTool\GitHub\Token::fromTokenString(getenv('APP_GITHUB_CLIENT_TOKEN'));

$container['github_client'] = function($c) {
    return \Bennoislost\GitHubTool\GitHub\ClientFactory::create(
        $c['github_token']
    );
};

$container['github_api_service_provider'] = function ($c) {
    return new \Bennoislost\GitHubTool\GitHub\ApiServiceProvider(
        $c['github_client']
    );
};

$container['cli_app_commands'] = function ($c) {
    return [
        new \Bennoislost\GitHubTool\GitHub\Milestones\FromRepositoryCommand(
            $c['github_api_service_provider']
        ),
        new \Bennoislost\GitHubTool\GitHub\PullRequests\FromRepositoryCommand(
            $c['github_api_service_provider']
        ),
        new \Bennoislost\GitHubTool\GitHub\Releases\FromRepositoryCommand(
            $c['github_api_service_provider']
        )

    ];
};

/**
 * @param $c
 *
 * @return \Symfony\Component\Console\Application
 */
$container['cli_app'] = function ($c) {
    $application = new Symfony\Component\Console\Application;
    $application->addCommands($c['cli_app_commands']);

    return $application;
};

return $container;
