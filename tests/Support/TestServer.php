<?php

declare(strict_types=1);

/*
 * This file is part of the adminata package.
 *
 * (c) IDCT Bartosz Pachołek <bartosz@idct.tech>
 *
 * Forked from the Sonata Project
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineORMAdminBundle\Tests\Support;

use Symfony\Component\Process\Process;

/**
 * The test application, served by PHP's built-in server for the Panther tests.
 *
 * Panther starts a web server of its own, but it binds the loopback interface, and the browser
 * this repository's docker-compose.yml offers runs in a container — which reaches the host through
 * the gateway, never through its own loopback. So every Panther run against that container failed
 * on a connection error, while the README told people to use it.
 *
 * This server binds every interface instead, and {@see baseUri()} hands the browser the address it
 * can actually dial. Panther is given that as `external_base_uri`, which makes it skip starting a
 * server at all, so there is still exactly one.
 */
final class TestServer
{
    private const int READY_ATTEMPTS = 60;

    private const int READY_INTERVAL_MICROSECONDS = 100_000;

    private static ?Process $process = null;

    /** The address the *browser* dials. */
    public static function baseUri(): string
    {
        self::start();

        return \sprintf('http://%s:%d', self::browserHost(), self::port());
    }

    public static function start(): void
    {
        if (null !== self::$process) {
            return;
        }

        // A port that answers is not proof that *this* application is the one answering, and the
        // failure that produces otherwise — a page of somebody else's markup — says nothing about
        // the cause.
        if (self::accepts()) {
            throw new \RuntimeException(\sprintf(
                'Port %d is already in use, so the test application cannot be served there. Set '
                .'ADMINATA_ORM_TEST_PORT to a free port.',
                self::port()
            ));
        }

        $process = new Process(
            [\PHP_BINARY, '-S', \sprintf('0.0.0.0:%d', self::port()), '-t', \dirname(__DIR__).'/App/public'],
            \dirname(__DIR__, 2),
            [
                'APP_ENV' => 'test',
                'APP_DEBUG' => '0',
                // PHP's built-in server is single-threaded, and a browser holds several
                // connections open at once: sooner or later it is blocked on a request it cannot
                // answer until one of the others finishes, and the page never loads.
                'PHP_CLI_SERVER_WORKERS' => '8',
            ],
        );
        $process->setTimeout(null);
        // PHP's built-in server logs a line per request and Symfony's Process buffers what it
        // writes. Nothing here drains those pipes, so once the operating system's buffer fills the
        // server blocks on the write and answers nothing more — a browser that hangs on the third
        // navigation of a run, and a WebDriver command that times out a minute later.
        $process->disableOutput();
        $process->start();

        self::$process = $process;
        register_shutdown_function(self::stop(...));

        self::waitUntilReady();
    }

    public static function stop(): void
    {
        self::$process?->stop();
        self::$process = null;
    }

    private static function waitUntilReady(): void
    {
        for ($attempt = 0; $attempt < self::READY_ATTEMPTS; ++$attempt) {
            if (self::accepts()) {
                return;
            }

            usleep(self::READY_INTERVAL_MICROSECONDS);
        }

        self::stop();

        throw new \RuntimeException(\sprintf('The test application did not answer on port %d.', self::port()));
    }

    private static function accepts(): bool
    {
        $connection = @fsockopen('127.0.0.1', self::port(), $errorCode, $errorMessage, 1);

        if (false === $connection) {
            return false;
        }

        fclose($connection);

        return true;
    }

    private static function port(): int
    {
        $port = $_SERVER['ADMINATA_ORM_TEST_PORT'] ?? null;

        return \is_string($port) && '' !== $port ? (int) $port : 9080;
    }

    /**
     * `PANTHER_SELENIUM_HOST` all but always means Selenium in a container, and a container
     * reaches this server through the host gateway rather than through its own loopback.
     */
    private static function browserHost(): string
    {
        $host = $_SERVER['ADMINATA_ORM_TEST_BROWSER_HOST'] ?? null;

        if (\is_string($host) && '' !== $host) {
            return $host;
        }

        $selenium = $_SERVER['PANTHER_SELENIUM_HOST'] ?? $_ENV['PANTHER_SELENIUM_HOST'] ?? null;

        return \is_string($selenium) && '' !== $selenium ? 'host.docker.internal' : '127.0.0.1';
    }
}
