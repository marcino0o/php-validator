<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\Email;

class EmailTest extends TestCase
{
    /**
     * @test
     * @dataProvider validEmailsProvider
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
     * @test
     * @dataProvider invalidEmailsProvider
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
            ['joe.doe'],
            ['joe doe@example.com'],
            ['joe.doe@ example.com'],
            ['joe.doe.example.com'],
        ];
    }

    /**
     * @test
     */
    public function shouldHandleBlockedDomains(): void
    {
        $sut = (new Email())->notInDomain('example.com', 'gmail.com');

        $this->assertFalse($sut->isSatisfiedBy('joe.doe@example.com'));
        $this->assertFalse($sut->isSatisfiedBy('joe.doe@gmail.com'));
        $this->assertTrue($sut->isSatisfiedBy('joe.doe@yahoo.com'));
    }

    /**
     * @test
     */
    public function shouldHandleAllowedDomains(): void
    {
        $sut = (new Email())->inDomain('example.com', 'gmail.com');

        $this->assertTrue($sut->isSatisfiedBy('joe.doe@example.com'));
        $this->assertTrue($sut->isSatisfiedBy('joe.doe@gmail.com'));
        $this->assertFalse($sut->isSatisfiedBy('joe.doe@yahoo.com'));
    }
}
