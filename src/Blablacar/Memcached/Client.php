<?php

namespace Blablacar\Memcached;

class Client
{
    protected $persistentId;

    protected $servers = array();
    protected $memcached;

    public function __construct($persistentId = null)
    {
        $this->persistentId = $persistentId;
    }

    /**
     * addServer
     *
     * @param string $host
     * @param int    $port
     * @param int    $weight
     *
     * @return void
     */
    public function addServer($host, $port, $weight = 0)
    {
        $this->servers[] = array($host, $port, $weight);
    }

    /**
     * addServers
     *
     * @param array $servers
     *
     * @return void
     */
    public function addServers(array $servers)
    {
        foreach ($servers as $server) {
            $this->addServer($server);
        }
    }

    /**
     * connect
     *
     * @return void
     */
    public function connect()
    {
        if (null !== $this->memcached) {
            return;
        }

        $this->memcached = new \Memcached($this->persistentId);
        $this->memcached->addServers($this->servers);
    }

    /**
     * getMemcached
     *
     * @return \Redis|null
     */
    public function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * __call
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        if (null === $this->memcached) {
            $this->connect();
        }

        return call_user_func_array(array($this->memcached, $name), $arguments);
    }
}
