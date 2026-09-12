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

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use IDCT\Adminata\DoctrineORM\DependencyInjection\Compiler\AddTemplatesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class AddTemplatesCompilerPassTest extends AbstractCompilerPassTestCase
{
    public function testDefaultBehavior(): void
    {
        $admin = new Definition(null);
        $admin->addMethodCall('setFilterTheme', [['custom_call.twig.html']]);
        $admin->addTag('adminata.admin', ['manager_type' => 'orm']);

        $this->setDefinition('my.admin', $admin);

        $this->compile();

        static::assertContainerBuilderHasServiceDefinitionWithMethodCall('my.admin', 'setFilterTheme', [['@AdminataDoctrineORM/Form/filter_admin_fields.html.twig', 'custom_call.twig.html']]);
        static::assertContainerBuilderHasServiceDefinitionWithMethodCall('my.admin', 'setFormTheme', [['@AdminataDoctrineORM/Form/form_admin_fields.html.twig']]);
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AddTemplatesCompilerPass());
    }
}
