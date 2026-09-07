<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineORMAdminBundle\Tests\Functional;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Sonata\DoctrineORMAdminBundle\Tests\Support\TestServer;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

abstract class BasePantherTestCase extends PantherTestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        // The application is served by TestServer rather than by Panther, whose own server binds
        // the loopback interface: a browser in a container cannot reach that. Handing Panther an
        // `external_base_uri` makes it skip starting one, so there is still exactly one server,
        // and the relative paths these tests request resolve against it unchanged.
        $options = [
            'external_base_uri' => TestServer::baseUri(),
            'connection_timeout_in_ms' => 5000,
            'request_timeout_in_ms' => 60000,
        ];

        $seleniumHost = self::stringFromServer('PANTHER_SELENIUM_HOST');

        // Same switch as idct/sonata-admin-mongodb-bundle: with PANTHER_SELENIUM_HOST set,
        // talk to a running Selenium (a container, or CI's service) instead of spawning a
        // local geckodriver. PANTHER_FIREFOX_PORT moves the spawned geckodriver off the
        // default 4444 when something else on the machine already listens there.
        if (null !== $seleniumHost) {
            $this->client = static::createPantherClient(
                ['browser' => PantherTestCase::SELENIUM] + $options,
                [],
                [
                    'host' => $seleniumHost,
                    'capabilities' => DesiredCapabilities::firefox(),
                ],
            );

            return;
        }

        $port = self::stringFromServer('PANTHER_FIREFOX_PORT');

        $this->client = static::createPantherClient(
            ['browser' => PantherTestCase::FIREFOX] + $options,
            [],
            null !== $port ? ['port' => (int) $port] : [],
        );
    }

    private static function stringFromServer(string $name): ?string
    {
        $value = $_SERVER[$name] ?? $_ENV[$name] ?? null;

        return \is_string($value) && '' !== $value ? $value : null;
    }
}
