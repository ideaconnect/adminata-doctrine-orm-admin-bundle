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

use IDCT\Adminata\Datagrid\Pager;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\AuthorAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\AuthorWithSimplePagerAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\BookAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\BookWithAuthorAutocompleteAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\CarAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\CategoryAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\ChildAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\ItemAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\MotherAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\SubAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\UlidChildEntityAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Admin\UuidEntityAdmin;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Author;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Book;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Car;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Category;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Child;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Item;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Mother;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\Sub;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\UlidChildEntity;
use IDCT\Adminata\DoctrineORM\Tests\App\Entity\UuidEntity;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->load('IDCT\\Adminata\\DoctrineORM\\Tests\\App\\DataFixtures\\', dirname(__DIR__).'/DataFixtures')

        ->set(CategoryAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Category::class,
                'label' => 'Category',
            ])

        ->set(BookAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Book::class,
                'label' => 'Book',
                'default' => true,
            ])

        ->set(BookWithAuthorAutocompleteAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Book::class,
                'label' => 'Book with Author autocomplete',
            ])

        ->set(AuthorAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Author::class,
                'label' => 'Author',
                'default' => true,
            ])
            ->call('setTemplate', ['outer_list_rows_list', 'author/list_outer_list_rows_list.html.twig'])

        ->set(AuthorWithSimplePagerAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Author::class,
                'label' => 'Author with Simple Pager',
                'pager_type' => Pager::TYPE_SIMPLE,
            ])
            ->call('setTemplate', ['outer_list_rows_list', 'author/list_outer_list_rows_list.html.twig'])

        ->set(CarAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Car::class,
                'label' => 'Car',
            ])

        ->set(ItemAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Item::class,
                'label' => 'Command item',
            ])

        ->set(SubAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Sub::class,
                'label' => 'Inheritance',
            ])

        ->set(MotherAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Mother::class,
                'label' => 'Mother',
            ])

        ->set(ChildAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => Child::class,
                'label' => 'Child',
            ])

        ->set(UuidEntityAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => UuidEntity::class,
                'label' => 'UuidEntity',
            ])

        ->set(UlidChildEntityAdmin::class)
            ->tag('adminata.admin', [
                'manager_type' => 'orm',
                'model_class' => UlidChildEntity::class,
                'label' => 'UlidChildEntity',
            ]);
};
