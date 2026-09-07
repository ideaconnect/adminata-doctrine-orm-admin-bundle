# adminata Doctrine ORM Admin Bundle

Doctrine ORM support for [adminata](https://github.com/ideaconnect/adminata) — the storage layer
that turns a Doctrine entity into a list, a filter, a form, a show page and an export.

This is a hard fork of `sonata-project/doctrine-orm-admin-bundle` 4.21.0. It `replace`s that
package, keeps the `Sonata\DoctrineORMAdminBundle\` namespace, the `SonataDoctrineORMAdminBundle`
bundle class, the `sonata_doctrine_orm_admin` configuration root and every service id, so an
application's admin classes, service definitions and YAML carry over untouched. What changes is
underneath: it is built against `idct/adminata` rather than the seven `sonata-project` packages.

> **Not on Packagist yet.** adminata and this bundle are released together; until then, install
> them from a VCS or path repository.

## Installation

```bash
composer require idct/adminata-doctrine-orm-admin-bundle
```

Register the two bundles in `config/bundles.php`:

```php
Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle::class => ['all' => true],
```

Two lines, not seven: `SonataAdminBundle` carries the block, Doctrine, form, Twig-helper and
exporter stacks, so there is no `SonataBlockBundle`, `SonataDoctrineBundle`, `SonataFormBundle`,
`SonataTwigBundle` or `SonataExporterBundle` to register.

Documentation: [`docs/`](docs), or `make docs` to build the site.

## Storage layers

| Layer | Package |
|---|---|
| Doctrine ORM | this one |
| Doctrine MongoDB ODM | [`idct/sonata-admin-mongodb-bundle`](https://github.com/ideaconnect/sonata-admin-mongodb-bundle) |

## Development

```bash
make install       # dependencies
make services-up   # the MySQL the suite runs against
make qa            # php-cs-fixer, PHPStan, Rector and PHPUnit
```

adminata supports MySQL, MariaDB and Percona; there is no SQLite support, so the suite needs a
running server. `docker compose up -d database` starts a matching MySQL on port 7010; point the
suite elsewhere with `DATABASE_URL` and `ADMINATA_TEST_DATABASE_URL`.

The Panther tests drive a real browser. Either install a geckodriver, or run
`docker compose up -d selenium` and export `PANTHER_SELENIUM_HOST=http://127.0.0.1:4444`. With that
set, the test application is served on every interface and the browser is handed
`host.docker.internal`, which is the only address a container can reach the host on.

The `legacy-ui` group is excluded by default: those scenarios click through the Bootstrap markup
adminata replaced, and they pass again when its milestones M3 and M4 rewrite the templates. Run
them with `vendor/bin/phpunit --group legacy-ui` to see where that stands.

## Licence

MIT. See [LICENSE](LICENSE) and [NOTICE](NOTICE); the upstream history is in
[CHANGELOG.md](CHANGELOG.md) and the imported commit is recorded in [UPSTREAM.md](UPSTREAM.md).
