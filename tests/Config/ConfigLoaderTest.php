<?php


namespace Tests\Config;


use MailServer\Config\ConfigLoader;

class ConfigLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldLoadConfigWithSuccess()
    {
        $configFile = __DIR__.'/../Fixtures/good_test_config.yml';
        $loader = new ConfigLoader();
        $loader->loadConfig($configFile);

        self::assertEquals("0.0.0.0", $loader->get('swiftmailer__host'));
        self::assertEquals(25, $loader->get('swiftmailer__port'));
        self::assertEquals("username", $loader->get('swiftmailer__username'));
        self::assertEquals("password", $loader->get('swiftmailer__password'));

        $goodConfig = array(
            'swiftmailer' => array(
                'host' => '0.0.0.0',
                'port' => 25,
                'username' => 'username',
                'password' => 'password'
            )
        );;
        self::assertEquals($goodConfig, $loader->get('swiftmailer'));
    }
    public function testShouldLoadConfigWithFail()
    {
        $configFile = __DIR__.'/../Fixtures/good_test_config.yml';
        $loader = new ConfigLoader();
        $loader->loadConfig($configFile);

        self::assertEquals("0.0.0.0", $loader->get('swiftmailer__host'));
        self::assertEquals(null, $loader->get('swiftmailer__pport'));
        self::assertEquals("username", $loader->get('swiftmailer__username'));
        self::assertEquals("password", $loader->get('swiftmailer__password'));
    }

}