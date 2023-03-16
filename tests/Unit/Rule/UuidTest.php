<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\Uuid;

class UuidTest extends TestCase
{
    /**
     * @test
     * @dataProvider validUuidProvider
     */
    public function shouldBeSatisfiedBy(string $uuid): void
    {
        $sut = (new Uuid())->v4();

        $this->assertTrue($sut->isSatisfiedBy($uuid));
    }

    public function validUuidProvider(): array
    {
        return [
            ['7c729a85-76e7-45df-b819-56f7af96c4c7'],
            ['58D98CF6-517D-4F0F-9F1A-77841BAE4AF9'],
            ['6148372A-3dab-448a-96c7-28EB580AAC27'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidUuidProvider
     */
    public function shouldNotBeSatisfiedBy(mixed $uuid): void
    {
        $sut = new Uuid();
        $this->assertFalse($sut->isSatisfiedBy($uuid));
    }

    public function invalidUuidProvider(): array
    {
        return [
            ['c729a85-76e7-45df-b819-56f7af96c4c7'],
            ['7c729a85-767-45df-b819-56f7af96c4c7'],
            ['7c729a85-76e7-4df-b819-56f7af96c4c7'],
            ['7c729a85-76e7-45df-b81-56f7af96c4c7'],
            ['7c729a85-76e7-45df-b819-56f7af96c47'],
            ['58g98cf6-517d-4f0f-9f1a-77841bae4af9'],
            ['517d-4f0f-9f1a-77841bae4af9'],
            [''],
            [123123131],
            [null]
        ];
    }
}
