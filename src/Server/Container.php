<?php

namespace Aurora\Server;

use Aurora\Event\SafeClosureEvent;
use Aurora\Http\Connection\ClientConnection;
use Aurora\Http\Connection\ServerConnection;
use Aurora\Http\Session\Session;
use Ev;
use EvIo;
use EvWatcher;

class Container
{
    const EVENT_CLIENT_CONNECT_BEFORE = 'server.client_connect::before';
    const EVENT_CLIENT_CONNECT_AFTER = 'server.client_connect::after';
    /**
     * @var ServerConnection[]
     */
    protected $connections;
    /**
     * @var Session[]
     */
    protected $sessions;
    /**
     * @var EvWatcher[]
     */
    protected $watchers = [];

    /**
     * Server constructor.
     *
     * @param array $connections
     */
    public function __construct($connections = [])
    {
        foreach ($connections as $connection) {
            list($address, $port) = explode(':', $connection);
            $this->connections[] = new ServerConnection($address, $port);
        }
    }

    public function start()
    {
        foreach ($this->connections as $connection) {
            $this->watchers[] = new EvIo(
                $connection->getSocket(),
                Ev::READ,
                SafeClosureEvent::wrapper(
                    function () use ($connection) {
                        $this->onClientConnect($connection);
                    }
                )
            );
        }
    }

    public function stop()
    {
        foreach ($this->watchers as $watcher) {
            $watcher->stop();
        }
        foreach ($this->connections as $connection) {
            $connection->close();
        }
    }

    public function onClientConnect(ServerConnection $connection)
    {
        $client = $connection->accept();
//        Aurxy::event(static::EVENT_CLIENT_CONNECT_BEFORE);
        $connection = new ClientConnection($client);
//        Aurxy::event(static::EVENT_CLIENT_CONNECT_AFTER);
        $this->sessions[] = new Session($connection);
    }
}