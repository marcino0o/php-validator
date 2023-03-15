<?php

declare(strict_types=1);

namespace Validator\Tests\Unit\Error;

use PHPUnit\Framework\TestCase;
use Validator\Dictionary\TypeStringDictionary;
use Validator\Error\Error;
use Validator\Rule\TypeString;

class ErrorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReplaceContextMergeWordsInAMessage(): void
    {
        $sut = (new TypeString())->minLength(5);
        $sut->withMessage(
            TypeStringDictionary::LENGTH_TOO_SHORT,
            'Min length {{ minLength }} is not satisfied by "{{ value }}"'
        );
        $sut->isSatisfiedBy('a');

        $this->assertEquals(
            'Min length 5 is not satisfied by "a"',
            $sut->getErrors()->first()->getMessage()
        );
    }

    /**
     * @test
     */
    public function shouldReturnContext(): void
    {
        $context = ['value' => 'xxx', 'min' => 0];
        $sut = new Error('Something went wrong', $context);
        $this->assertEquals($context, $sut->getContext());
    }
}
