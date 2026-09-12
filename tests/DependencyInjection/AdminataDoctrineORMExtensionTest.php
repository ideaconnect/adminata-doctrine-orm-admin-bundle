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

namespace IDCT\Adminata\DoctrineORM\Tests\DependencyInjection;

use IDCT\Adminata\DoctrineORM\DependencyInjection\AdminataDoctrineORMExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AdminataDoctrineORMExtensionTest extends TestCase
{
    public function testEntityManagerSetFactory(): void
    {
        $configuration = new ContainerBuilder();
        $configuration->setParameter('kernel.bundles', ['SimpleThingsEntityAuditBundle' => true]);
        $loader = new AdminataDoctrineORMExtension();
        $loader->load([], $configuration);

        $definition = $configuration->getDefinition('adminata.admin.entity_manager');

        static::assertNotNull($definition->getFactory());
        static::assertNotFalse($configuration->getParameter('adminata_doctrine_orm.audit.force'));
    }
}
