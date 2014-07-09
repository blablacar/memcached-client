<?php

namespace Blablacar\Memcached\Test;

use Blablacar\Memcached\Client as BaseClient;

/**
 * Client
 *
 * The only purpose of this class is to be used to mock the default Client with
 * prophecy which can't mock magic methods like __call
 */
class Client extends BaseClient
{
    public function __construct() {}

    public function add() {}
    public function addByKey() {}
    public function append() {}
    public function appendByKey() {}
    public function cas() {}
    public function casByKey() {}
    public function decrement() {}
    public function decrementByKey() {}
    public function delete() {}
    public function deleteByKey() {}
    public function deleteMulti() {}
    public function deleteMultiByKey() {}
    public function fetch() {}
    public function fetchAll() {}
    public function flush() {}
    public function get() {}
    public function getAllKeys() {}
    public function getByKey() {}
    public function getDelayed() {}
    public function getDelayedByKey() {}
    public function getMulti() {}
    public function getMultiByKey() {}
    public function getOption() {}
    public function getResultCode() {}
    public function getResultMessage() {}
    public function getServerByKey() {}
    public function getServerList() {}
    public function getStats() {}
    public function getVersion() {}
    public function increment() {}
    public function incrementByKey() {}
    public function isPersistent() {}
    public function isPristine() {}
    public function prepend() {}
    public function prependByKey() {}
    public function quit() {}
    public function replace() {}
    public function replaceByKey() {}
    public function resetServerList() {}
    public function set() {}
    public function setByKey() {}
    public function setMulti() {}
    public function setMultiByKey() {}
    public function setSaslAuthData() {}
    public function touch() {}
    public function touchByKey() {}
}
