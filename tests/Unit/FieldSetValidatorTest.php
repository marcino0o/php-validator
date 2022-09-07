<?php

declare(strict_types=1);

namespace Validator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Validator\FieldSetValidator;
use Validator\FieldValidator;
use Validator\Rule\Email;
use Validator\Rule\TypeString;

class FieldSetValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRequireField(): void
    {
        $sut = new FieldSetValidator(
            FieldValidator::required('email', new Email),
            FieldValidator::required('email2', new Email)->nullable(),
            FieldValidator::requiredWith('email3', 'email', new Email),
        );

        $sut->validate([
            'email' => 'joe.doe@example.com',
            'email2' => null,
            'email3' => 'joe.doe@example.com'
        ]);

        $this->assertFalse($sut->hasErrors());
    }

    /**
     * @test
     */
    public function shouldNotRequireField(): void
    {
        $sut = new FieldSetValidator(
            FieldValidator::optional('email', new Email),
        );

        $sut->validate([]);

        $this->assertFalse($sut->hasErrors());
    }

    /**
     * @test
     */
    public function shouldBeNotValidWhenRequiredFieldMissing(): void
    {
        $sut = new FieldSetValidator(
            FieldValidator::required('email', new Email),
        );

        $sut->validate([]);

        $this->assertTrue($sut->hasErrors());
        $this->assertArrayHasKey('email', $sut->getErrors());
    }

    /**
     * @test
     */
    public function shouldNotAllowNull(): void
    {
        $sut = new FieldSetValidator(
            FieldValidator::required('email', new Email),
        );

        $sut->validate(['email' => null]);

        $this->assertTrue($sut->hasErrors());
        $this->assertArrayHasKey('email', $sut->getErrors());
    }

    /**
     * @test
     */
    public function shouldNotSatisfyRules(): void
    {
        $sut = new FieldSetValidator(
            FieldValidator::required('email', new Email, (new TypeString())->maxLength(5)),
        );

        $sut->validate(['email' => 'joe.doe.example.com']);

        $this->assertTrue($sut->hasErrors());
        $this->assertCount(1, $sut->getErrors());
        $this->assertArrayHasKey('email', $sut->getErrors());
    }
}
