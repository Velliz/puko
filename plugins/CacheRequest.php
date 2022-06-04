<?php

namespace plugins;

use Memcached;
use pukoframework\config\Config;

/**
 * Class CacheRequest
 * @package plugins
 *
 * $data = CacheRequest::Key('stuff')->Get();
 * $data = CacheRequest::Key('stuff')->Set($data, $expired);
 * $data = CacheRequest::Key('stuff')->Delete();
 */
class CacheRequest
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var array|string
     */
    protected $data;

    /**
     * @var null|object
     */
    protected $memcached = null;

    /**
     * @var bool
     */
    protected $active = true;

    /**
     * CacheRequest constructor.
     * @param $key
     */
    protected function __construct($key)
    {
        $config = Config::Data('app')['cache'];
        $this->active = ($config['active'] === 'true');

        $this->key = $key;

        if ($this->active) {
            $this->memcached = new Memcached();
            $this->memcached->addServer($config['host'], $config['port']);
        }
    }

    /**
     * @param $key
     * @return CacheRequest
     */
    public static function Key($key)
    {
        return new CacheRequest($key);
    }

    /**
     * @param $data
     * @param $expired
     * @return mixed
     */
    public function Set($data, $expired)
    {
        if (!$this->active) {
            return false;
        }
        $this->memcached->set($this->key, $data, $expired);
        return $this->memcached->get($this->key);
    }

    /**
     * @return mixed
     */
    public function Get()
    {
        if (!$this->active) {
            return false;
        }
        return $this->memcached->get($this->key);
    }

    /**
     * @return mixed
     */
    public function Delete()
    {
        if (!$this->active) {
            return false;
        }
        return $this->memcached->delete($this->key);
    }

    /**
     * @return Memcached|object|null
     */
    public function getObject()
    {
        return $this->memcached;
    }

}
