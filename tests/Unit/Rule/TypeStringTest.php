<?php

declare(strict_types=1);

namespace Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\TypeString;

class TypeStringTest extends TestCase
{
    private const RANGE_TEST_MIN_LENGTH = 2;
    private const RANGE_TEST_MAX_LENGTH = 4;

    /**
     * @test
     * @dataProvider validStringProvider
     */
    public function shouldBeSatisfied(string $string): void
    {
        $sut = new TypeString();
        $this->assertTrue($sut->isSatisfiedBy($string));
    }

    public function validStringProvider(): array
    {
        return [
            ['a'],
            ['a b c d'],
            ['123'],
            ['$%^&'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidStringProvider
     */
    public function shouldNotBeSatisfied(mixed $string): void
    {
        $sut = new TypeString();
        $this->assertFalse($sut->isSatisfiedBy($string));
    }

    public function invalidStringProvider(): array
    {
        return [
            [null],
            [123],
            [false],
            [12.123],
        ];
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWhenStringTooShort(): void
    {
        $string = str_repeat('a', self::RANGE_TEST_MIN_LENGTH - 1);

        $sut = (new TypeString())->minLength(self::RANGE_TEST_MIN_LENGTH);
        $this->assertFalse($sut->isSatisfiedBy($string));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWhenStringTooLong(): void
    {
        $string = str_repeat('a', self::RANGE_TEST_MAX_LENGTH + 1);

        $sut = (new TypeString())->maxLength(self::RANGE_TEST_MAX_LENGTH);
        $this->assertFalse($sut->isSatisfiedBy($string));
    }

    /**
     * @test
     * @dataProvider inARangeStringProvider
     */
    public function shouldBeSatisfiedWhenStringInARange(string $string): void
    {
        $sut = (new TypeString())->lengthBetween(self::RANGE_TEST_MIN_LENGTH, self::RANGE_TEST_MAX_LENGTH);
        $this->assertTrue($sut->isSatisfiedBy($string));
    }

    public function inARangeStringProvider(): array
    {
        $data = [];

        for ($i = self::RANGE_TEST_MIN_LENGTH; $i <= self::RANGE_TEST_MAX_LENGTH; $i++) {
            $data[] = [str_repeat('a', $i)];
        }

        return $data;
    }
}
