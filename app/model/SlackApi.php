<?php


namespace App\Model;


use Faker\Factory;
use Nette\Database\Context;
use Nette\Database\UniqueConstraintViolationException;
use Nette\DI\Container;

class SlackApi
{

    private $cache;
    const TOKEN_NAME = 'token';

    public function __construct(Container $context)
    {
        $this->cache = new \Nette\Caching\Cache($context->getByType(\Nette\Caching\IStorage::class));
    }

    public function saveToken($token)
    {
        $this->cache->save(self::TOKEN_NAME, $token);
    }

    public function getToken()
    {
        return $this->cache->load(self::TOKEN_NAME);
    }
}
