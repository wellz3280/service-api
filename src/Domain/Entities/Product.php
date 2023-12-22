<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;

use function is_int;

final class Product extends AbstractEntity
{
    public function __construct(
        protected int|null $id,
        private string $name,
        private string $manufacturer,
        private string $model,
        private string $serial,
        private Customer $customer,
        protected int|null $createdAt,
        protected int|null $deletedAt = null,
        protected int|null $updatedAt = null,
    ) {
    }

    /**
     * @param array{
     *  id: int|null,
     *  name: string,
     *  manufacturer: string,
     *  model: string,
     *  serial: string,
     *  customer: Customer,
     *  created_at?: int|null,
     *  deleted_at?: int|null,
     *  updated_at?: int|null
     * } $data
     */
    public static function createFromArray(array $data): self
    {
        $createdAt = $data['created_at'] ?? null;
        if (is_int($createdAt)) {
            $createdAt = (new DateTimeImmutable())->setTimestamp($createdAt)->getTimestamp();
        }

        return new self(
            $data['id'] ?? null,
            $data['name'],
            $data['manufacturer'],
            $data['model'],
            $data['serial'],
            $data['customer'],
            $createdAt ?? (new DateTimeImmutable())->getTimestamp(),
            $data['deleted_at'] ?? null,
            $data['updated_at'] ?? null,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function withManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function withModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function withSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'manufacturer'  => $this->manufacturer,
            'model'         => $this->model,
            'serial'        => $this->serial,
            'created_at'    => $this->createdAt,
            'deleted_at'    => $this->deletedAt,
            'updated_at'    => $this->updatedAt,
        ];
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
