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

namespace IDCT\Adminata\DoctrineORM\Tests\DependencyInjection\Compiler;

use IDCT\Adminata\DoctrineORM\DependencyInjection\Compiler\AddAuditEntityCompilerPass;
use IDCT\Adminata\DoctrineORM\Tests\Fixtures\Entity\Product;
use IDCT\Adminata\DoctrineORM\Tests\Fixtures\Entity\SimpleEntity;
use IDCT\Adminata\DoctrineORM\Tests\Fixtures\Entity\UuidEntity;
use IDCT\Adminata\DoctrineORM\Tests\Fixtures\Entity\VersionedEntity;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class AddAuditEntityCompilerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @phpstan-return iterable<array-key, array{bool, array<string, array{audit?: bool|null, class: class-string}>, class-string[]}>
     */
    public static function provideProcessCases(): iterable
    {
        yield [
            true,
            [
                'admin1' => ['audit' => null,  'class' => Product::class],
                'admin2' => ['audit' => true,  'class' => SimpleEntity::class],
                'admin3' => ['audit' => false, 'class' => UuidEntity::class],
                'admin4' => ['class' => VersionedEntity::class],
            ],
            [
                Product::class,
                SimpleEntity::class,
                VersionedEntity::class,
            ],
        ];
        yield [
            false,
            [
                'admin1' => ['audit' => null,  'class' => Product::class],
                'admin2' => ['audit' => true,  'class' => SimpleEntity::class],
                'admin3' => ['audit' => false, 'class' => UuidEntity::class],
                'admin4' => ['class' => VersionedEntity::class],
            ],
            [
                SimpleEntity::class,
            ],
        ];
    }

    /**
     * @phpstan-param array<string, array{audit?: bool|null, class: class-string}> $services
     * @phpstan-param class-string[] $expectedAuditedEntities
     */
    #[DataProvider('provideProcessCases')]
    public function testProcess(bool $force, array $services, array $expectedAuditedEntities): void
    {
        $this->setDefinition('simplethings_entityaudit.config', new Definition());
        $this->setDefinition('adminata.admin.audit.manager', new Definition());

        $this->setParameter('adminata_doctrine_orm.audit.force', $force);
        $this->setParameter('simplethings.entityaudit.audited_entities', []);

        foreach ($services as $serviceId => $service) {
            $definition = new Definition();

            $attributes = [
                'manager_type' => 'orm',
                'model_class' => $service['class'],
            ];

            if (isset($service['audit'])) {
                $attributes['audit'] = $service['audit'];
            }

            $definition->addTag('adminata.admin', $attributes);

            $this->setDefinition($serviceId, $definition);
        }

        $this->compile();

        static::assertContainerBuilderHasParameter('simplethings.entityaudit.audited_entities', $expectedAuditedEntities);
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AddAuditEntityCompilerPass());
    }
}
