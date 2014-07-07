<?php

namespace Blablacar\Memcached;

use Blablacar\Memcached\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_initializable()
    {
        $this->assertInstanceOf('Blablacar\Memcached\Client', new Client());
    }

    public function test_connect_create_a_memcached_connection()
    {
        $client = new Client();
        $client->addServer('127.0.0.1', 11211);
        $this->assertNull($client->getMemcached());
        $client->connect();
        $this->assertInstanceOf('\Memcached', $client->getMemcached());
    }

    public function test_call_a_method_create_a_memcached_connection()
    {
        $client = new Client();
        $client->addServer('127.0.0.1', 11211);
        $this->assertNull($client->getMemcached());
        $return = $client->get('foo.bar');
        $this->assertInstanceOf('\Memcached', $client->getMemcached());
        $this->assertFalse($return);
    }

    public function test_set_get()
    {
        $client = new Client();
        $client->addServer('127.0.0.1', 11211);
        $this->assertEquals(1, $client->set('foobar', 42));
        $this->assertEquals(42, $client->get('foobar'));
    }
}
