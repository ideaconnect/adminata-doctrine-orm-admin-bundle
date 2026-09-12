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

namespace IDCT\Adminata\DoctrineORM\Tests;

use PHPUnit\Framework\TestCase;
use IDCT\Adminata\DoctrineORM\DependencyInjection\Compiler\AddAuditEntityCompilerPass;
use IDCT\Adminata\DoctrineORM\DependencyInjection\Compiler\AddGuesserCompilerPass;
use IDCT\Adminata\DoctrineORM\DependencyInjection\Compiler\AddTemplatesCompilerPass;
use IDCT\Adminata\DoctrineORM\AdminataDoctrineORMBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class AdminataDoctrineORMBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $containerBuilder = new ContainerBuilder();

        $bundle = new AdminataDoctrineORMBundle();
        $bundle->build($containerBuilder);

        static::assertNotNull($this->findCompilerPass($containerBuilder, AddGuesserCompilerPass::class));
        static::assertNotNull($this->findCompilerPass($containerBuilder, AddTemplatesCompilerPass::class));
        static::assertNotNull($this->findCompilerPass($containerBuilder, AddAuditEntityCompilerPass::class));
    }

    private function findCompilerPass(ContainerBuilder $container, string $class): ?CompilerPassInterface
    {
        foreach ($container->getCompiler()->getPassConfig()->getPasses() as $pass) {
            if ($pass instanceof $class) {
                return $pass;
            }
        }

        return null;
    }
}
