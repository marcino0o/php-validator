<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Rule;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Validator\Dictionary\EmailDictionary;
use Validator\Rule\Email;

class RuleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldOverwriteSingleMessage(): void
    {
        $customMessage = 'No good! Fix it or else..';

        $sut = new Email();
        $sut->withMessage(EmailDictionary::MUST_BE_AN_EMAIL, $customMessage);
        $sut->isSatisfiedBy('aaa');
        $this->assertEquals($customMessage, $sut->getErrors()->first()->getMessage());

        $sut->isSatisfiedBy('marcin@i-am-not-valid-domain.com');
        $this->assertEquals(
            EmailDictionary::MESSAGES[EmailDictionary::MUST_HAVE_VALID_DOMAIN],
            $sut->getErrors()->first()->getMessage()
        );
    }

    /**
     * @test
     */
    public function shouldOverwriteManyMessages(): void
    {
        $customMessage1 = 'No good! Fix it or else..';
        $customMessage2 = 'You fool! Wrong again.';

        $sut = new Email();
        $sut->withMessages([
            EmailDictionary::MUST_BE_AN_EMAIL => $customMessage1,
            EmailDictionary::MUST_HAVE_VALID_DOMAIN => $customMessage2,
        ]);

        $sut->isSatisfiedBy('aaa');
        $this->assertEquals($customMessage1, $sut->getErrors()->first()->getMessage());

        $sut->isSatisfiedBy('marcin@i-am-not-valid-domain.com');
        $this->assertEquals($customMessage2, $sut->getErrors()->first()->getMessage());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenSettingMessageForNotExistingRuleError(): void
    {
        $customMessage = 'No good! Fix it or else..';

        $sut = new Email();
        $this->expectException(InvalidArgumentException::class);
        $sut->withMessage('nonExisingError', $customMessage);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenAnyOfRuleErrorsForReplacementNotExists(): void
    {
        $sut = new Email();
        $this->expectException(InvalidArgumentException::class);
        $sut->withMessages(['invalidCountryCode' => 'It is not a country']);
    }

    /**
     * @test
     */
    public function shouldNotHaveError(): void
    {
        $sut = new Email;
        $sut->isSatisfiedBy('joedoe@example.com');
        $this->assertNull($sut->getErrors()->first());
    }
}
