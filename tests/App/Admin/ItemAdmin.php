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

namespace IDCT\Adminata\DoctrineORM\Tests\App\Admin;

use IDCT\Adminata\Admin\AbstractAdmin;
use IDCT\Adminata\Datagrid\ListMapper;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Item;

/**
 * @phpstan-extends AbstractAdmin<Item>
 */
final class ItemAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('command.id', null, [
                'sortable' => true,
                'sort_field_mapping' => [
                    'fieldName' => 'id',
                ],
                'sort_parent_association_mappings' => [[
                    'fieldName' => 'command',
                ]],
            ])
            ->add('product.name', null, [
                'sortable' => true,
                'sort_field_mapping' => [
                    'fieldName' => 'name',
                ],
                'sort_parent_association_mappings' => [[
                    'fieldName' => 'product',
                ]],
            ])
            ->add('offeredPrice');
    }
}
