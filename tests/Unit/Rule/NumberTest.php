<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\Number;

class NumberTest extends TestCase
{
    /**
     * @test
     * @dataProvider validNumberProvider
     */
    public function shouldBeSatisfiedByAnyNumber(int|float $number): void
    {
        $sut = new Number();
        $this->assertTrue($sut->isSatisfiedBy($number), sprintf('Assertion failed with %s', $number));
    }

    public function validNumberProvider(): array
    {
        return [
            [-10.1],
            [-10],
            [0],
            [10],
            [10.1]
        ];
    }

    /**
     * @test
     * @dataProvider notNumberProvider
     */
    public function shouldNotBeSatisfiedByNotNumber(mixed $notNumber): void
    {
        $sut = new Number();
        $this->assertFalse($sut->isSatisfiedBy($notNumber), sprintf('Assertion failed with %s', $notNumber));
    }

    public function notNumberProvider(): array
    {
        return [
            [null],
            ['123'],
            [false],
            [true],
        ];
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithFloatNumber(): void
    {
        $sut = new Number();
        $sut->integer();
        $this->assertFalse($sut->isSatisfiedBy(10.1));
    }

    /**
     * @test
     */
    public function shouldBeSatisfiedWithFloatNumber(): void
    {
        $sut = new Number();
        $sut->float();
        $this->assertTrue($sut->isSatisfiedBy(10.1));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithIntegerNumber(): void
    {
        $sut = new Number();
        $sut->float();
        $this->assertFalse($sut->isSatisfiedBy(10));
    }

    /**
     * @test
     */
    public function shouldBeSatisfiedWithIntegerNumber(): void
    {
        $sut = new Number();
        $sut->integer();
        $this->assertTrue($sut->isSatisfiedBy(10));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedSignedNumber(): void
    {
        $sut = new Number();
        $sut->unsigned();
        $this->assertFalse($sut->isSatisfiedBy(-10));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithGraterNumber(): void
    {
        $sut = new Number();
        $sut->max(10);
        $this->assertTrue($sut->isSatisfiedBy(10));
        $this->assertFalse($sut->isSatisfiedBy(10.1));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithLowerNumber(): void
    {
        $sut = new Number();
        $sut->min(10.1);
        $this->assertFalse($sut->isSatisfiedBy(10));
        $this->assertTrue($sut->isSatisfiedBy(10.1));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithOutOfRangeNumber(): void
    {
        $sut = new Number();
        $sut->between(0, 10);
        $this->assertFalse($sut->isSatisfiedBy(-1));
        $this->assertTrue($sut->isSatisfiedBy(0));
        $this->assertTrue($sut->isSatisfiedBy(10));
        $this->assertFalse($sut->isSatisfiedBy(11));
    }
}
