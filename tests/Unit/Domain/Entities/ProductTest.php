<?php

declare(strict_types=1);

namespace tests\Unit\Domain\Entities;

use DateTimeImmutable;
use Domain\Entities\Customer;
use Domain\Entities\Product;
use Tests\TestCase;

use const DATE_ATOM;

/**
 * @covers Domain\Entities\Product
 */
final class ProductTest extends TestCase
{
    public function testInstantiateProductFromStaticMethod(): void
    {
        $datetime = (new DateTimeImmutable())->getTimestamp();
        $expected = [
            'id'            => 1,
            'name'          => 'playstation 5',
            'manufacturer'  => 'sony',
            'model'         => 'CHT102030',
            'serial'        => 'WDJK1278HJ899',
            'customer'      => Customer::createFromArray([
                'id'    => 1,
                'name'  => 'leon kennedy',
                'email' => 'leon.k@umbrella.com',
            ]),
            'created_at'     => $datetime,
            'deleted_at'     => $datetime,
            'updated_at'     => $datetime,
        ];
        $product = Product::createFromArray($expected);

        $this->assertSame($expected['id'], $product->getId());
        $this->assertSame($expected['name'], $product->getName());
        $this->assertSame($expected['manufacturer'], $product->getManufacturer());
        $this->assertSame($expected['model'], $product->getModel());
        $this->assertSame($expected['serial'], $product->getSerial());
        $this->assertSame($expected['created_at'], $product->getCreatedAtFromTimeStanp());
        $this->assertSame((new DateTimeImmutable())->format(DATE_ATOM), $product->getCreatedAt());
        $this->assertSame($expected['deleted_at'], $product->getDeletedAtFromTimeStanp());
        $this->assertSame((new DateTimeImmutable())->format(DATE_ATOM), $product->getDeletedAt());
        $this->assertSame($expected['updated_at'], $product->getUpdatedAtFromTimeStanp());
        $this->assertSame((new DateTimeImmutable())->format(DATE_ATOM), $product->getUpdatedAt());
    }

    public function testInitializePropertiesFromSetterMethods(): void
    {
        $product = Product::createFromArray([
            'id'            => 1,
            'name'          => 'ps5',
            'manufacturer'  => 'sony',
            'model'         => 'CHT102030',
            'serial'        => 'WDJK1278HJ899',
            'customer'      => Customer::createFromArray([
                'id'    => 1,
                'name'  => 'leon kennedy',
                'email' => 'leon.k@umbrella.com',
            ]),
            'createdAt'     => (new DateTimeImmutable())->getTimestamp(),
            'deletedAt'     => null,
            'updatedAt'     => null,
        ]);

        $this->assertSame('playstation 5', $product->withName('playstation 5')->getName());
        $this->assertSame('sony playstation', $product->withManufacturer('sony playstation')->getManufacturer());
        $this->assertSame('CHT10203040', $product->withModel('CHT10203040')->getModel());
        $this->assertSame('WDJK1278HJ809', $product->withSerial('WDJK1278HJ809')->getSerial());
    }

    public function testInstantiateProductWithoutOptionalParameters(): void
    {
        $product = Product::createFromArray([
            'id'            => 1,
            'name'          => 'ps5',
            'manufacturer'  => 'sony',
            'model'         => 'CHT102030',
            'serial'        => 'WDJK1278HJ899',
            'customer'      => Customer::createFromArray([
                'id'    => 1,
                'name'  => 'leon kennedy',
                'email' => 'leon.k@umbrella.com',
            ]),
        ]);

        $datetime = (new DateTimeImmutable())->getTimestamp();

        $this->assertSame($datetime, $product->getCreatedAtFromTimeStanp());
        $this->assertNull($product->getUpdatedAt());
        $this->assertNull($product->getDeletedAt());
    }
}
