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

use IDCT\Adminata\DoctrineORM\Datagrid\ProxyQuery;
use IDCT\Adminata\DoctrineORM\Filter\UidFilter;
use IDCT\Adminata\Filter\Model\FilterData;

final class UidFilterTest extends FilterTestCase
{
    public function testSearchEnabled(): void
    {
        $filter = new UidFilter();
        $filter->initialize('field_name');
        static::assertFalse($filter->isSearchEnabled());

        $filter = new UidFilter();
        $filter->initialize('field_name', ['global_search' => true]);
        static::assertTrue($filter->isSearchEnabled());
    }

    public function testEmpty(): void
    {
        $filter = new UidFilter();
        $filter->initialize('field_name');

        $proxyQuery = new ProxyQuery($this->createQueryBuilderStub());

        $filter->filter($proxyQuery, 'alias', 'field', FilterData::fromArray([]));
        $filter->filter($proxyQuery, 'alias', 'field', FilterData::fromArray(['value' => '']));

        self::assertSameQuery([], $proxyQuery);
        static::assertFalse($filter->isActive());
    }
}
