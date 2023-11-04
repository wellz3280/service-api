<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entities;

use DateTimeImmutable;
use Domain\Entities\AbstractEntity;
use Tests\TestCase;

use const DATE_ATOM;
/**
 * @covers Domain\Entities\AbstractEntity
 */
final class AbstractEntityTest extends TestCase
{
    public function testCreateInstance(): void
    {
        $id                     = 1;
        $createdAt              = (new DateTimeImmutable())->format(DATE_ATOM);
        $createFromTimeStamp    = (new DateTimeImmutable())->getTimestamp();
        $toArray                = ['id' => $id, 'createdAt' => $createFromTimeStamp, 'deletedAt' => null, 'updatedAt' => null];

        $entity = new class($id, $createFromTimeStamp, null, null) extends AbstractEntity
        {
            protected ?int $id;
            protected ?int $createdAt;
            protected ?int $deletedAt;
            protected ?int $updatedAt;

            public function __construct(?int $id, ?int $createdAt, ?int $deletedAt, ?int $updatedAt)
            {
                $this->id           = $id;
                $this->createdAt    = $createdAt;
                $this->deletedAt    = $deletedAt;
                $this->updatedAt    = $updatedAt;
            }
        };

        $this->assertSame($id, $entity->getId());
        $this->assertSame($createdAt, $entity->getCreatedAt());
        $this->assertSame($toArray, $entity->toArray());
    }
}
