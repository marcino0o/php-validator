<?php

declare(strict_types=1);

namespace Validator\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Validator\Dictionary\FieldDictionary;
use Validator\Field;
use Validator\Rule\TypeArray;
use Validator\Rule\TypeString;

class FieldTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionReplacingNotExistingMessage(): void
    {
        $sut = Field::optional('name', new TypeString());
        $this->expectException(InvalidArgumentException::class);
        $sut->withMessages(['nonExistingError' => 'Useless message']);
    }

    /**
     * @test
     */
    public function shouldReplaceValidationErrorMessage(): void
    {
        $newMessage = 'I must have value other than null';

        $sut = Field::optional('name', new TypeString());
        $sut->withMessages([FieldDictionary::FIELD_IS_NOT_NULLABLE => $newMessage]);
        $sut->validate(['name' => null]);

        $this->assertEquals($newMessage, $sut->getErrors()->first()->getMessage());
    }

    /**
     * @test
     */
    public function shouldBeRequiredWhenOtherKeyExists(): void
    {
        $sut = Field::requiredWith('multi.level.key', 'multi.level', new TypeArray());
        $sut->validate(['multi' => ['level' => 'value']]);

        $this->assertTrue($sut->hasErrors());
    }

    /**
     * @test
     */
    public function shouldNotBeRequiredWhenOtherKeyIsMissing(): void
    {
        $sut1 = Field::requiredWith('multi.level.key', 'multi.level', new TypeArray());
        $sut1->validate(['multi' => ['key' => 'value']]);

        $this->assertFalse($sut1->hasErrors());

        $sut2 = Field::requiredWith('multi.level.key', 'multi', new TypeArray());
        $sut2->validate(['some' => ['key' => 'value']]);

        $this->assertFalse($sut2->hasErrors());
    }
}
