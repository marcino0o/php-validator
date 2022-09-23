<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\TypeArray;

class TypeArrayTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeSatisfied(): void
    {
        $sut = new TypeArray;
        $this->assertTrue($sut->isSatisfiedBy([]));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfied(): void
    {
        $sut = new TypeArray;
        $this->assertFalse($sut->isSatisfiedBy(''));
    }

    /**
     * @test
     */
    public function shouldBeSatisfiedWithAllowedKeys(): void
    {
        $sut = (new TypeArray)->withAllowedKeys('first', 'second');
        $this->assertTrue($sut->isSatisfiedBy(['first' => 1, 'second' => 2]));
        $this->assertTrue($sut->isSatisfiedBy(['first' => 1]));
        $this->assertTrue($sut->isSatisfiedBy(['second' => 2]));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWithNotAllowedKeys(): void
    {
        $sut = (new TypeArray)->withAllowedKeys('first', 'second');
        $this->assertFalse($sut->isSatisfiedBy(['first' => 1, 'second' => 2, 'third' => 3]));
        $this->assertFalse($sut->isSatisfiedBy(['zero' => 0]));
        $this->assertFalse($sut->isSatisfiedBy([1 => 'first']));
    }

    /**
     * @test
     */
    public function shouldBeSatisfiedWithRequiredKeys(): void
    {
        $sut = (new TypeArray)->withRequiredKeys('first', 'second');
        $this->assertTrue($sut->isSatisfiedBy(['first' => 1, 'second' => 2]));
        $this->assertTrue($sut->isSatisfiedBy(['first' => 1, 'second' => 2, 'third' => 3]));
    }

    /**
     * @test
     */
    public function shouldNotBeSatisfiedWhenRequiredKeyIsMissing(): void
    {
        $sut = (new TypeArray)->withRequiredKeys('first', 'second');
        $this->assertFalse($sut->isSatisfiedBy(['first' => 1]));
        $this->assertFalse($sut->isSatisfiedBy(['third' => 3]));
    }
}
