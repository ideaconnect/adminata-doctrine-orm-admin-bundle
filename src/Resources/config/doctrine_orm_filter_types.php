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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use IDCT\Adminata\DoctrineORM\Filter\BooleanFilter;
use IDCT\Adminata\DoctrineORM\Filter\CallbackFilter;
use IDCT\Adminata\DoctrineORM\Filter\ChoiceFilter;
use IDCT\Adminata\DoctrineORM\Filter\ClassFilter;
use IDCT\Adminata\DoctrineORM\Filter\CountFilter;
use IDCT\Adminata\DoctrineORM\Filter\DateFilter;
use IDCT\Adminata\DoctrineORM\Filter\DateRangeFilter;
use IDCT\Adminata\DoctrineORM\Filter\DateTimeFilter;
use IDCT\Adminata\DoctrineORM\Filter\DateTimeRangeFilter;
use IDCT\Adminata\DoctrineORM\Filter\EmptyFilter;
use IDCT\Adminata\DoctrineORM\Filter\ModelAutocompleteFilter;
use IDCT\Adminata\DoctrineORM\Filter\ModelFilter;
use IDCT\Adminata\DoctrineORM\Filter\NullFilter;
use IDCT\Adminata\DoctrineORM\Filter\NumberFilter;
use IDCT\Adminata\DoctrineORM\Filter\StringFilter;
use IDCT\Adminata\DoctrineORM\Filter\StringListFilter;
use IDCT\Adminata\DoctrineORM\Filter\TimeFilter;
use IDCT\Adminata\DoctrineORM\Filter\UidFilter;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()

        ->set('adminata.admin.orm.filter.type.boolean', BooleanFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_boolean'])

        ->set('adminata.admin.orm.filter.type.callback', CallbackFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_callback'])

        ->set('adminata.admin.orm.filter.type.choice', ChoiceFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_choice'])

        ->set('adminata.admin.orm.filter.type.class', ClassFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_class'])

        ->set('adminata.admin.orm.filter.type.count', CountFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_count'])

        ->set('adminata.admin.orm.filter.type.date', DateFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_date'])

        ->set('adminata.admin.orm.filter.type.date_range', DateRangeFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_date_range'])

        ->set('adminata.admin.orm.filter.type.datetime', DateTimeFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_datetime'])

        ->set('adminata.admin.orm.filter.type.datetime_range', DateTimeRangeFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_datetime_range'])

        ->set('adminata.admin.orm.filter.type.empty', EmptyFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_empty'])

        ->set('adminata.admin.orm.filter.type.model', ModelFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_model'])

        ->set('adminata.admin.orm.filter.type.null', NullFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_null'])

        ->set('adminata.admin.orm.filter.type.number', NumberFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_number'])

        ->set('adminata.admin.orm.filter.type.string', StringFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_string'])

        ->set('adminata.admin.orm.filter.type.string_list', StringListFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_string_list'])

        ->set('adminata.admin.orm.filter.type.time', TimeFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_time'])

        ->set('adminata.admin.orm.filter.type.uid', UidFilter::class)
            ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_uid']);

    /*
     * NEXT_MAJOR: Remove this service definition.
     */
    $containerConfigurator->services()->set('adminata.admin.orm.filter.type.model_autocomplete', ModelAutocompleteFilter::class)
        ->tag('adminata.admin.filter.type', ['alias' => 'doctrine_orm_model_autocomplete']);
};
