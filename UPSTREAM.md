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

`composer.json` `replace`s that package at exactly that version.

## Remote

```bash
git remote add upstream https://github.com/sonata-project/SonataDoctrineORMAdminBundle.git
git fetch --no-tags upstream '+refs/tags/*:refs/upstream/*'
```

## What adminata changed

The namespace, the bundle class, the configuration root, the service ids and the templates' paths
are unchanged — the point of the fork is that an application does not notice it. What did change:

- It is built against `idct/adminata` instead of `sonata-project/{admin-bundle,exporter,
  form-extensions}`. Those three are one package now, so the imports that named
  `Sonata\Exporter\` and `Sonata\Form\` name `Sonata\AdminBundle\Exporter\` and
  `Sonata\AdminBundle\Form\` instead, and `Sonata\Doctrine\` — the old
  `sonata-project/doctrine-extensions` — is `Sonata\AdminBundle\Doctrine\`.
- The floors moved up with adminata's: PHP 8.4, Symfony 7.4 or 8.0, Doctrine ORM 3.6, DBAL 4.
- The views inherited from upstream are being rewritten for adminata's Tailwind interface. The
  ones still carrying the old markup are listed in adminata's `PLAN/03`.
- The test harness is this repository's own: `tests/PHPUnit/DatabaseExtension.php` and
  `tests/Support/` replace the `custom_bootstrap.php` upstream used and the adminata test-support
  classes the suite borrowed while it was a directory in that repository. There is no SQLite
  support — the suite runs against MySQL, MariaDB or Percona.

An upstream release is ported by hand: there is no `git subtree pull` path back, because the
sources moved out of `packages/doctrine-orm-admin-bundle/` when they were split into this
repository.
