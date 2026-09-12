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
use IDCT\Adminata\DoctrineORM\Filter\EmptyFilter;
use IDCT\Adminata\Filter\Model\FilterData;
use IDCT\Adminata\Form\Type\BooleanType;
use PHPUnit\Framework\Attributes\DataProvider;

final class EmptyFilterTest extends FilterTestCase
{
    public function testEmpty(): void
    {
        $filter = new EmptyFilter();
        $filter->initialize('field_name', [
            'field_options' => ['class' => 'FooBar'],
        ]);

        $proxyQuery = new ProxyQuery($this->createQueryBuilderStub());

        $filter->filter($proxyQuery, 'alias', 'field', FilterData::fromArray([]));

        self::assertSameQuery([], $proxyQuery);
        static::assertFalse($filter->isActive());
    }

    #[DataProvider('provideValueCases')]
    public function testValue(bool $inverse, int $value, string $expectedQuery): void
    {
        $filter = new EmptyFilter();
        $filter->initialize('field_name', [
            'field_options' => ['class' => 'FooBar'],
            'inverse' => $inverse,
        ]);

        $proxyQuery = new ProxyQuery($this->createQueryBuilderStub());
        self::assertSameQuery([], $proxyQuery);

        $filter->filter($proxyQuery, 'alias', 'field', FilterData::fromArray(['value' => $value]));

        self::assertSameQuery([$expectedQuery], $proxyQuery);
        static::assertTrue($filter->isActive());
    }

    public function testRenderSettings(): void
    {
        $filter = new EmptyFilter();
        $filter->initialize('field_name', [
            'field_options' => ['class' => 'FooBar'],
        ]);
        $options = $filter->getRenderSettings()[1];

        static::assertSame(BooleanType::class, $options['field_type']);
    }

    /**
     * @phpstan-return iterable<array{bool, int, string}>
     */
    public static function provideValueCases(): iterable
    {
        yield [false, BooleanType::TYPE_YES, 'WHERE alias.field IS EMPTY'];
        yield [false, BooleanType::TYPE_NO, 'WHERE alias.field IS NOT EMPTY'];
        yield [true, BooleanType::TYPE_YES, 'WHERE alias.field IS NOT EMPTY'];
        yield [true, BooleanType::TYPE_NO, 'WHERE alias.field IS EMPTY'];
    }
}
