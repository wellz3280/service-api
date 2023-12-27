<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entities;

use Domain\Entities\Service;
use Tests\TestCase;

/**
 * @covers Domain\Entities\Service
 */
final class ServiceTest extends TestCase
{
    public function testInstantiateServiceFromStaticMethod(): void
    {
        $expected   = [
            'id'            => 1,
            'name'          => 'troca de pasta térmica',
            'description'   => 'limpeza do processador e aplicação de pasta térmica',
            'console'       => 'PS4',
            'value'         => 79.99,
        ];
        $service    = Service::createFromArray($expected);

        $this->assertSame($expected['id'], $service->getId());
        $this->assertSame($expected['name'], $service->getName());
        $this->assertSame($expected['description'], $service->getDescription());
        $this->assertSame($expected['console'], $service->getConsole());
        $this->assertSame($expected['value'], $service->getValue());
    }
}
