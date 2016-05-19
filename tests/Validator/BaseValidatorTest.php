<?php


namespace Tests\Validator;


use MailServer\Validator\AbstractValidator;

abstract class BaseValidatorTest extends \PHPUnit_Framework_TestCase
{
    abstract public function testValidatorShouldReturnTrue();

    abstract public function testValidatorShouldThowExceptionBecauseOfMissingRootKey();

    abstract public function testValidatorShouldThowExceptionBecauseOfMissingKey();

    protected function subKeysTester(AbstractValidator $validator, array $rootConfig, $key)
    {
        try {
            $validator->validate($rootConfig);
        } catch (\Exception $e) {
            self::assertTrue($e instanceof \RuntimeException);
            self::assertEquals("Config key " . $key . " must be set", $e->getMessage());
        }
    }
}