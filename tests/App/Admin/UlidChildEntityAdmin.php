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
use IDCT\Adminata\Datagrid\DatagridMapper;
use IDCT\Adminata\Datagrid\ListMapper;
use IDCT\Adminata\Form\FormMapper;
use IDCT\Adminata\Form\Type\ModelAutocompleteType;
use IDCT\Adminata\Show\ShowMapper;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\UlidChildEntity;
use Symfony\Component\Uid\Ulid;

/**
 * @phpstan-extends AbstractAdmin<UlidChildEntity>
 */
final class UlidChildEntityAdmin extends AbstractAdmin
{
    protected function createNewInstance(): UlidChildEntity
    {
        return new UlidChildEntity(new Ulid());
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('parent', null, [
                'field_type' => ModelAutocompleteType::class,
                'field_options' => [
                    'property' => 'name',
                    'multiple' => true,
                ],
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('parent');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('name')
            ->add('parent');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name')
            ->add('parent');
    }
}
