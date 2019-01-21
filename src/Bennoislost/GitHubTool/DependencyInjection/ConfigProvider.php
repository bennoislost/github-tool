<?php

namespace Bennoislost\GitHubTool\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['config.files'] = function ($pimple) {
            return [$pimple['config.file']];
        };
        $pimple['config.hydrate'] = $pimple->protect(function ($pimple) {
            foreach ($pimple['config.files'] as $file) {
                if (is_file($file) && is_readable($file)) {
                    $values = require $file;
                    if (is_array($values)) {
                        foreach ($values as $key => $value) {
                            $pimple[$key] = $value;
                        }
                    } else {
                        throw new \InvalidArgumentException("Configuration file must return an array");
                    }
                } else {
                    throw new \RuntimeException("Could not find or read from {$file}");
                }
            }
        });
    }
}
