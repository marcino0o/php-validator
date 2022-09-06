<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\JWTString;

class JWTStringTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeSatisfied(): void
    {
        $sut = new JWTString();
        $this->assertTrue($sut->isSatisfiedBy('aaa.bbb.ccc'));
    }

    /**
     * @test
     * @dataProvider invalidJWTStrings
     */
    public function shouldNotBeSatisfied(mixed $subject): void
    {
        $sut = new JWTString();
        $this->assertFalse($sut->isSatisfiedBy($subject));
    }

    public function invalidJWTStrings(): array
    {
        return [
            ['aaa'],
            ['aaa.bbb'],
            ['aaa.bbb.'],
            ['aaa.bbb.12!'],
            [122.123],
            [''],
            [null]
        ];
    }
}
