<?php

declare(strict_types=1);

namespace Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\TypeArray;

class TypeArrayTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeSatisfied(): void
    {
        $sut = new TypeArray();
        $this->assertTrue($sut->isSatisfiedBy([]));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfied(): void
    {
        $sut = new TypeArray();
        $this->assertFalse($sut->isSatisfiedBy(''));
    }
}
