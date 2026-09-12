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

namespace IDCT\Adminata\DoctrineORM\Tests\Filter;

use IDCT\Adminata\Filter\Model\FilterData;
use IDCT\Adminata\DoctrineORM\Datagrid\ProxyQuery;
use IDCT\Adminata\DoctrineORM\Filter\DateTimeFilter;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class DateTimeFilterTest extends FilterTestCase
{
    public function testEmpty(): void
    {
        $filter = new DateTimeFilter();
        $filter->initialize('field_name', ['field_options' => ['class' => 'FooBar']]);

        $proxyQuery = new ProxyQuery($this->createQueryBuilderStub());

        $filter->filter($proxyQuery, 'alias', 'field', FilterData::fromArray(['value' => '']));

        self::assertSameQuery([], $proxyQuery);
        static::assertFalse($filter->isActive());
    }

    public function testGetType(): void
    {
        $filter = new DateTimeFilter();
        $filter->initialize('foo');

        static::assertSame(DateTimeType::class, $filter->getFieldType());
    }
}
