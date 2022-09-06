<?php

declare(strict_types=1);

namespace RWS\Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use RWS\Validator\Rule\Email;

class EmailTest extends TestCase
{
    /**
     * @param string $email
     * @dataProvider validEmailsProvider
     * @test
     */
    public function shouldBeSatisfiedBy(string $email): void
    {
        $sut = new Email();

        $this->assertTrue($sut->isSatisfiedBy($email));
    }

    public function validEmailsProvider(): array
    {
        return [
            ['joe.doe@example.com'],
            ['joe+doe@example.com'],
            ['joedoe@example.com'],
            ['joe-doe@example.com'],
            ['joe_doe@example.com'],
            ['joe.doe+1234@example.com'],
        ];
    }

    /**
     * @param string $email
     * @dataProvider invalidEmailsProvider
     * @test
     */
    public function shouldNotBeSatisfiedBy(string $email): void
    {
        $sut = new Email();

        $this->assertFalse($sut->isSatisfiedBy($email));
    }

    public function invalidEmailsProvider(): array
    {
        return [
            ['example.com'],
            ['@example.com'],
            ['joe.doe@example'],
            ['joe.doe@not.existing.example.com'],
            ['joe.doe']
        ];
    }
}
