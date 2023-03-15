<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\TypeDateTime;

class TypeDateTimeTest extends TestCase
{
    /**
     * @test
     * @dataProvider validDateTimeProvider
     */
    public function shouldBeSatisfied(mixed $dateString): void
    {
        $sut = new TypeDateTime();
        $this->assertTrue($sut->isSatisfiedBy($dateString));
    }

    public function validDateTimeProvider(): array
    {
        return [
            ['2022-01-10 12:22:12'],
            ['2022-01-10T12:22:12.0000'],
            ['2022-01-10T12:22:12+1'],
            ['01/22/2022'],
            ['20220912120000']
        ];
    }

    /**
     * @test
     * @dataProvider invalidDateTimeProvider
     */
    public function shouldNotBeSatisfied(mixed $dateString): void
    {
        $sut = new TypeDateTime();
        $this->assertFalse($sut->isSatisfiedBy($dateString));
    }

    public function invalidDateTimeProvider(): array
    {
        return [
            ['2022-13-12 12:22:12'],
            ['2022-12-12 37:22:12'],
            ['2022-12-32 00:00:00'],
//            ['2022-12 12:22:12'],
//            ['2022-02-30'], this one should not be valid
            ['fgh']
        ];
    }
}
