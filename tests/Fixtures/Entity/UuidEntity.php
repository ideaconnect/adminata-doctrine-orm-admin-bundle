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

namespace IDCT\Adminata\DoctrineORM\Tests\Fixtures\Entity;

use IDCT\Adminata\DoctrineORM\Tests\Fixtures\Util\NonIntegerIdentifierTestClass;

final class UuidEntity
{
    public function __construct(private NonIntegerIdentifierTestClass $uuid)
    {
    }

    public function getId(): NonIntegerIdentifierTestClass
    {
        return $this->uuid;
    }
}
