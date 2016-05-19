<?php


namespace Tests\Validator;


use MailServer\Validator\SwiftMailerValidator;

class SwiftMailerValidatorTest extends BaseValidatorTest
{
    public function testValidatorShouldReturnTrue()
    {
        $config = array(
            'swiftmailer' => array(
                'host' => '0.0.0.0',
                'port' => 25,
                'username' => 'username',
                'password' => 'password'
            )
        );
        $validator = new SwiftMailerValidator();

        self::assertTrue($validator->validate($config));
    }

    public function testValidatorShouldThowExceptionBecauseOfMissingRootKey()
    {
        $config = ['szwiftmail' => ['host' => '0.0.0.0','port' => 25,'username' => 'username','password' => 'password']];

        $validator = new SwiftMailerValidator();
        try {
            $validator->validate($config);
        } catch(\Exception $e) {
            self::assertTrue($e instanceof \RuntimeException);
            self::assertEquals("Config key swiftmailer must be set", $e->getMessage());
        }
    }

    public function testValidatorShouldThowExceptionBecauseOfMissingKey()
    {
        $config1 = ['swiftmailer' => ['port' => 25,'username' => 'username','password' => 'password']];
        $config2 = ['swiftmailer' => ['host' => '0.0.0.0','username' => 'username','password' => 'password']];
        $config3 = ['swiftmailer' => ['host' => '0.0.0.0','port' => 25,'password' => 'password']];
        $config4 = ['swiftmailer' => ['host' => '0.0.0.0','port' => 25,'username' => 'username']];

        $validator = new SwiftMailerValidator();

        parent::subKeysTester($validator, $config1, 'host'    );
        parent::subKeysTester($validator, $config2, 'port'    );
        parent::subKeysTester($validator, $config3, 'username');
        parent::subKeysTester($validator, $config4, 'password');
    }
}