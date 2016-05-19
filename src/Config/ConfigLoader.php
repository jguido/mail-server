<?php


namespace MailServer\Config;


use MailServer\Cache\Cacheable;
use MailServer\Validator\SwiftMailerValidator;
use Symfony\Component\Yaml\Yaml;

class ConfigLoader
{
    use Cacheable {
        Cacheable::__construct as private setUpCache;
    }

    /**
     * @var array
     */
    private $config;

    private $swiftMailerConfig;

    public function __construct()
    {
        $this->setUpCache();
    }

    public function loadConfig($configPath)
    {
        //__DIR__.'/../../../config/config.yml'
        $this->config = Yaml::parse(file_get_contents($configPath));
        $this->loadSwiftMailerConfig($this->config);
    }

    public function get($key)
    {
        if ($this->cache->get($key)) {
            return $this->cache->get($key);
        }
        if (strpos($key, '__')) {
            list($rootKey, $subKey) = explode('__', $key);
            if (isset($this->config[$rootKey]) && isset($this->config[$rootKey][$subKey])) {
                $this->cache->set($key, $this->config[$rootKey][$subKey], MEMCACHE_COMPRESSED, 36000 * 24);
                return $this->config[$rootKey][$subKey];
            }
        } else {
            if (isset($this->config[$key]) && isset($this->config[$key])) {
                $this->cache->set($key, $this->config[$key], MEMCACHE_COMPRESSED, 36000 * 24);
                return $this->config[$key];
            }
        }

        return null;
    }

    /**
     * @param array $config
     * @return bool
     */
    private function loadSwiftMailerConfig(array $configs)
    {
        $conf = $this->extractConfiguration($configs, "swiftmailer");
        $config = array('swiftmailer' => $conf);
        $validator = new SwiftMailerValidator();

        $validator->validate($config);
        $this->swiftMailerConfig = $config;
        $this->cache->set('swiftmailer', $config, MEMCACHE_COMPRESSED, 3600*24);
    }

    /**
     * @param array $configs
     * @param $rootKey
     * @return array
     */
    private final function extractConfiguration(array $configs, $rootKey) {
        foreach ($configs as $config => $subKeys) {
            if ($config === $rootKey) {
                return $configs[$config];
            }
        }
        throw new \RuntimeException(sprintf("%s not found in configuration!", $rootKey));
    }
}