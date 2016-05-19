<?php


namespace MailServer\Cache;


trait Cacheable
{
    private $cache;

    private function __construct()
    {
        $this->cache = new \Memcache();
        $this->cache->addserver("127.0.0.1", 11211);
    }

}