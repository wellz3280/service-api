<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use JsonSerializable;
use UnexpectedValueException;

use function get_object_vars;
use function is_null;
use function json_decode;
use function json_encode;

use const DATE_ATOM;

abstract class AbstractEntity implements JsonSerializable
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?string
    {
        if ($this->createdAt === 0 || is_null($this->createdAt)) {
            return null;
        }

        return (new DateTimeImmutable())
            ->setTimestamp($this->createdAt)
            ->format(DATE_ATOM);
    }

    public function getCreatedAtFromTimeStanp(): int
    {
        return $this->createdAt;
    }

    public function getDeletedAt(): ?string
    {
        if ($this->deletedAt === 0 || is_null($this->deletedAt)) {
            return null;
        }

        return (new DateTimeImmutable())
            ->setTimestamp($this->deletedAt)
            ->format(DATE_ATOM);
    }

    public function getDeletedAtFromTimeStanp(): ?int
    {
        return $this->deletedAt;
    }

    public function getUpdatedAt(): ?string
    {
        if ($this->updatedAt === 0 || is_null($this->updatedAt)) {
            return null;
        }

        return (new DateTimeImmutable())
            ->setTimestamp($this->updatedAt)
            ->format(DATE_ATOM);
    }

    public function getUpdatedAtFromTimeStanp(): ?int
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        $json = json_encode(get_object_vars($this));

        if ($json === false) {
            throw new UnexpectedValueException('Could not decode atributes to json');
        }

        return json_decode($json, true);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
