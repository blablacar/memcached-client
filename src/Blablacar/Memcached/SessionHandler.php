<?php

namespace Blablacar\Memcached;

class SessionHandler implements \SessionHandlerInterface
{
    protected $client;
    protected $prefix;
    protected $ttl;

    /**
     * __construct.
     *
     * @param Client $client A redis client
     * @param string $prefix The prefix to use for keys (default: "session")
     * @param int    $ttl    A ttl for keys (default: null = no ttl)
     */
    public function __construct(Client $client, $prefix = 'session', $ttl = null)
    {
        $this->client       = $client;
        $this->prefix       = $prefix;
        $this->ttl          = $ttl;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * {@inheritDoc}
     */
    public function read($sessionId)
    {
        $key = $this->getSessionKey($sessionId);
        if (false === $data = $this->client->get($key)) {
            $data = '';
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        if (null === $this->ttl) {
            $return = $this->client->set(
                $this->getSessionKey($sessionId),
                (string) $data
            );
        } else {
            $return = $this->client->set(
                $this->getSessionKey($sessionId),
                (string) $data,
                time() + $this->ttl
            );
        }

        return $return;
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($sessionId)
    {
        $this->client->delete($this->getSessionKey($sessionId));
        $this->close();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function gc($lifetime)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        $this->client->quit();

        return true;
    }

    /**
     * getSessionKey.
     *
     * @param string $sessionId
     *
     * @return string
     */
    protected function getSessionKey($sessionId)
    {
        return sprintf('%s:%s', $this->prefix, $sessionId);
    }
}
