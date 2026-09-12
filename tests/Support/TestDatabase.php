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

namespace IDCT\Adminata\DoctrineORM\Tests\Support;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

/**
 * Resolves the databases the test suites run against.
 *
 * adminata supports MySQL, MariaDB and Percona; there is no SQLite support, so the tests that
 * need a database use the MySQL of this repository's `docker-compose.yml`. Point them at another
 * server with `ADMINATA_TEST_DATABASE_URL` (the entity manager of the unit tests) or
 * `DATABASE_URL` (the functional application).
 *
 * @phpstan-import-type Params from DriverManager
 */
final class TestDatabase
{
    public const string DEFAULT_URL = 'mysql://root:adminata@127.0.0.1:7010/adminata_test?serverVersion=8.4.0&charset=utf8mb4';

    /**
     * @return array<string, mixed>
     *
     * @phpstan-return Params
     */
    public static function parameters(string $variable = 'ADMINATA_TEST_DATABASE_URL', ?string $database = null): array
    {
        $url = $_SERVER[$variable] ?? $_ENV[$variable] ?? null;

        if (!\is_string($url) || '' === $url) {
            $url = self::DEFAULT_URL;
        }

        $parameters = new DsnParser(['mysql' => 'pdo_mysql', 'mariadb' => 'pdo_mysql'])->parse($url);

        if (null !== $database) {
            $parameters['dbname'] = $database;
        }

        return $parameters;
    }

    /**
     * Creates the database of the given parameters, optionally dropping it first, and returns a
     * connection to it.
     *
     * @param array<string, mixed> $parameters
     *
     * @phpstan-param Params $parameters
     */
    public static function connect(array $parameters, bool $drop = false): Connection
    {
        $database = $parameters['dbname'] ?? null;

        if (\is_string($database) && '' !== $database) {
            $server = $parameters;
            unset($server['dbname']);

            // Not `Connection::quoteSingleIdentifier()`: that arrived in doctrine/dbal 4.3 and the
            // `lowest` CI row installs 4.0. A database name is a plain identifier, so require one.
            if (1 !== preg_match('/^[A-Za-z0-9_$]+$/', $database)) {
                throw new \InvalidArgumentException(\sprintf('"%s" is not a usable database name.', $database));
            }

            $quoted = '`'.$database.'`';

            $connection = DriverManager::getConnection($server);

            if ($drop) {
                $connection->executeStatement(\sprintf('DROP DATABASE IF EXISTS %s', $quoted));
            }

            $connection->executeStatement(\sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
                $quoted
            ));
            $connection->close();
        }

        return DriverManager::getConnection($parameters);
    }
}
