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
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Mother;
use IDCT\Adminata\Form\FormMapper;
use IDCT\Adminata\Form\Type\CollectionType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @phpstan-extends AbstractAdmin<Mother>
 */
final class MotherAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('children', CollectionType::class, [
            'by_reference' => false,
            'constraints' => [
                new Assert\Valid(),
            ],
        ], [
            'edit' => 'inline',
            'inline' => 'table',
        ]);
    }
}
