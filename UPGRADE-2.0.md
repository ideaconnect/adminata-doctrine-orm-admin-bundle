# Upgrading to 2.0

2.0 renames everything in this package that carried the Sonata name, together with adminata's own
rename. The complete guide — Composer, `bundles.php`, configuration, PHP, Twig, markup, the tool
that makes the edits for you, and the one edit that is a data migration — is
[adminata's UPGRADE.md](https://github.com/ideaconnect/adminata/blob/main/UPGRADE.md). The rows
that are this package's:

| Before | After |
|---|---|
| `idct/adminata-doctrine-orm-admin-bundle` `^1.0` | `^2.0` (same package name) |
| `Sonata\DoctrineORMAdminBundle\` | `IDCT\Adminata\DoctrineORM\` |
| `Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle` in `bundles.php` | `IDCT\Adminata\DoctrineORM\AdminataDoctrineORMBundle` |
| `config/packages/sonata_doctrine_orm_admin.yaml`, root `sonata_doctrine_orm_admin:` | `adminata_doctrine_orm.yaml`, `adminata_doctrine_orm:` |
| `@SonataDoctrineORMAdmin/…` | `@AdminataDoctrineORM/…` |
| `sonata.admin.manager.orm`, `sonata.admin.orm.filter.type.*`, every other `sonata.admin.*` id of this package | `adminata.admin.…` |
| `Sonata\DoctrineORMAdminBundle\Filter\StringFilter` and every other class | the same class under the new namespace |
| the form theme's `sonata_type_*` blocks | `adminata_type_*` |
| `replace: sonata-project/doctrine-orm-admin-bundle` | `conflict` — an explicit `require` of the upstream package must go |

Your own admin services keep their ids unless you decide otherwise: the `ROLE_*` names the
security handlers derive from an admin's code are stored in your users' roles
(UPGRADE.md §6.3).

```console
$ vendor/bin/adminata-rename --app --dry-run .   # what changes, and which names are yours
$ vendor/bin/adminata-rename --app .
```
