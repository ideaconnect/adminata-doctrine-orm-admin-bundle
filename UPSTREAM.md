# Upstream

This repository is a hard fork of `sonata-project/doctrine-orm-admin-bundle`. It was imported into
the [adminata](https://github.com/ideaconnect/adminata) repository with `git subtree` as
`packages/doctrine-orm-admin-bundle`, developed there alongside the other six forked trees, and
split out again with `git subtree split` on 2026-09-07 — so the history below the split commit is
the upstream history, commit for commit, followed by adminata's changes to it.

## Imported version

| Upstream package | Namespace | Tag | Upstream commit | Released |
|---|---|---|---|---|
| `sonata-project/doctrine-orm-admin-bundle` | `Sonata\DoctrineORMAdminBundle\` | 4.21.0 | `214739047182fc85ab97ade350fdc461cb1d52cf` | 2026-01-05 |

Until 2.0, `composer.json` `replace`d that package at exactly that version. Since the rename of
2026-09-12 it `conflict`s with it instead: this bundle provides the same behaviour under the
`IDCT\Adminata\DoctrineORM\` namespace, so an installation cannot hold both, and nothing that
requires the upstream package would work with this one.

## Remote

```bash
git remote add upstream https://github.com/sonata-project/SonataDoctrineORMAdminBundle.git
git fetch --no-tags upstream '+refs/tags/*:refs/upstream/*'
```

## What adminata changed

Until 2.0 the namespace, the bundle class, the configuration root, the service ids and the
templates' paths were unchanged — an application did not notice the fork. Since 2.0 every one of
those names is adminata's: `IDCT\Adminata\DoctrineORM\`, `AdminataDoctrineORMBundle`,
`adminata_doctrine_orm`, `adminata.admin.*`, `@AdminataDoctrineORM`. The rename was performed
by adminata's engine (`vendor/idct/adminata/upstream/rename/`), which is also what translates an
upstream diff before it is ported. The map is in adminata's UPGRADE.md. What else changed:

- It is built against `idct/adminata` instead of `sonata-project/{admin-bundle,exporter,
  form-extensions}`. Those three are one package now, so the imports that named
  `Sonata\Exporter\` and `Sonata\Form\` name `IDCT\Adminata\Exporter\` and
  `IDCT\Adminata\Form\` instead, and `Sonata\Doctrine\` — the old
  `sonata-project/doctrine-extensions` — is `IDCT\Adminata\Doctrine\`.
- The floors moved up with adminata's: PHP 8.4, Symfony 7.4 or 8.0, Doctrine ORM 3.6, DBAL 4.
- The views inherited from upstream are being rewritten for adminata's Tailwind interface. The
  ones still carrying the old markup are listed in adminata's `PLAN/03`.
- The test harness is this repository's own: `tests/PHPUnit/DatabaseExtension.php` and
  `tests/Support/` replace the `custom_bootstrap.php` upstream used and the adminata test-support
  classes the suite borrowed while it was a directory in that repository. There is no SQLite
  support — the suite runs against MySQL, MariaDB or Percona.

An upstream release is ported by hand: there is no `git subtree pull` path back, because the
sources moved out of `packages/doctrine-orm-admin-bundle/` when they were split into this
repository. Run the upstream diff through adminata's engine first
(`php vendor/idct/adminata/upstream/rename/apply.php --stdin --as <path>` per file), so that it
reads in this repository's names.
