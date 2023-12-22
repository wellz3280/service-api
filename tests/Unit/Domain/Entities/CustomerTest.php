<?php

declare(strict_types=1);

namespace tests\Unit\Domain\Entities;

use DateTimeImmutable;
use Domain\Entities\Customer;
use Tests\TestCase;

/**
 * @covers  Domain\Entities\Customer
 */
final class CustomerTest extends TestCase
{
    public function testInstantiateCustomerFromStaticMethod(): void
    {
        $expedted = [
            'id'    => 1,
            'name'  => 'luis serra',
            'email' => 'luis.serra@umbrela.com',
        ];

        $customer = Customer::createFromArray($expedted);

        $this->assertSame($expedted['id'], $customer->getId());
    }

    public function testInitializePropertiesFromSetterMethods(): void
    {
        $customer = Customer::createFromArray([
            'id'    => 1,
            'name'  => 'luis serra',
            'email' => 'luis.serra@umbrela.com',
        ]);

        $this->assertSame('luis sierra', $customer->withName('luis sierra')->getName());
    }

    public function testInstantiateProductWithoutOptionalParameters(): void
    {
        $customer = Customer::createFromArray([
            'id'    => 1,
            'name'  => 'luis serra',
            'email' => 'luis.serra@umbrela.com',
        ]);

        $datetime = (new DateTimeImmutable())->getTimestamp();

        $this->assertSame($datetime, $customer->getCreatedAtFromTimeStanp());
        $this->assertNull($customer->getUpdatedAt());
        $this->assertNull($customer->getDeletedAt());
    }
}
