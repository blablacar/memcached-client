<?php

namespace Blablacar\Memcached;

use Prophecy\Argument;

class SessionHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_initializable()
    {
        $client = $this->prophesize('Blablacar\Memcached\Test\Client');
        $this->assertInstanceOf(
            'Blablacar\Memcached\SessionHandler',
            new SessionHandler($client->reveal())
        );
    }

    public function test_read_without_key()
    {
        $client = $this->prophesize('Blablacar\Memcached\Test\Client');
        $client->quit()->shouldBeCalledTimes(1);
        $client->get(Argument::exact('session:foobar'))->willReturn(false);

        $handler = new SessionHandler($client->reveal());

        $this->assertEquals('', $handler->read('foobar'));
    }

    public function test_read_with_key()
    {
        $client = $this->prophesize('Blablacar\Memcached\Test\Client');
        $client->quit()->shouldBeCalledTimes(1);
        $client->get(Argument::exact('session:foobar'))->willReturn('foobar');

        $handler = new SessionHandler($client->reveal());

        $this->assertEquals('foobar', $handler->read('foobar'));
    }

    public function test_write_with_ttl()
    {
        $client = $this->prophesize('Blablacar\Memcached\Test\Client');
        $client->quit()->shouldBeCalledTimes(1);
        $client->set(
            Argument::type('string'),
            Argument::type('string'),
            Argument::exact(time() + 1200)
        )->will(function ($args) {
            $this->get($args[0])->willReturn($args[1])->shouldBeCalledTimes(1);

            return true;
        })->shouldBeCalledTimes(1);

        $handler = new SessionHandler($client->reveal(), 'session', 1200);

        $this->assertTrue($handler->write('key', 'value'));
        $this->assertEquals('value', $handler->read('key'));
    }

    public function test_write_without_ttl()
    {
        $client = $this->prophesize('Blablacar\Memcached\Test\Client');
        $client->quit()->shouldBeCalledTimes(1);
        $client->set(
            Argument::type('string'),
            Argument::type('string')
        )->will(function ($args) {
            $this->get($args[0])->willReturn($args[1])->shouldBeCalledTimes(1);

            return true;
        })->shouldBeCalledTimes(1);

        $handler = new SessionHandler($client->reveal());

        $this->assertTrue($handler->write('key', 'value'));
        $this->assertEquals('value', $handler->read('key'));
    }
}
