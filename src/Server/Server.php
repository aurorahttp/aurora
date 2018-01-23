<?php

namespace Aurora\Server;

use Aurora;
use Aurora\Event\SafeClosureEvent;
use Ev;
use EvSignal;
use EvWatcher;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Server
{
    /**
     * @var string
     */
    protected $bootstrap;
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var EventDispatcher
     */
    protected $event;
    /**
     * @var Logger
     */
    protected $log;
    /**
     * @var array
     */
    protected $options;
    /**
     * @var EvWatcher[]
     */
    protected $watchers;

    /**
     * Server constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->configure($options);
        $this->log = $this->createLogger();
        Aurora::$server = $this;
    }

    public function run()
    {
        $this->watchers[] = new EvSignal(SIGKILL, SafeClosureEvent::wrapper(function () {
            $this->shutdown();
        }));
        $this->watchers[] = new EvSignal(SIGTERM, SafeClosureEvent::wrapper(function () {
            $this->shutdown();
        }));
        $this->watchers[] = new EvSignal(SIGUSR2, SafeClosureEvent::wrapper(function() {
            $this->bootstrap();
            // Aurora::debug("Reload bootstrap");
        }));
        $this->bootstrap();
        $this->container = new Container((array)$this->options['server']['listen']);
        $this->container->start();

        Ev::run(Ev::FLAG_AUTO);
    }

    /**
     * Stop server and exit.
     */
    public function shutdown()
    {
        $this->container->stop();
        Ev::stop();

        exit(0);
    }

    /**
     * @param array $options
     */
    public function configure($options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults($this->getDefaultOptions());
        $this->options = $resolver->resolve($options);
    }

    /**
     * Init event dispatcher and load bootstrap file.
     *
     * If again call this method, will lose old event subscribes.
     */
    public function bootstrap()
    {
        $this->event = new EventDispatcher();
        if (! empty($this->bootstrap) && is_file($this->bootstrap)) {
            include($this->bootstrap);
        }
    }

    /**
     * @return string
     */
    public function getBootstrap(): string
    {
        return $this->bootstrap;
    }

    /**
     * @param string $bootstrap
     */
    public function setBootstrap(string $bootstrap)
    {
        $this->bootstrap = $bootstrap;
    }

    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return [
            'server' => [
                'listen' => [
                    '127.0.0.1:10085',
                ],
            ],
            'log' => [],
        ];
    }

    /**
     * @return EventDispatcher
     */
    public function getEvent(): EventDispatcher
    {
        return $this->event;
    }

    /**
     * @return Logger
     */
    public function getLog(): Logger
    {
        return $this->log;
    }

    /**
     * @return Logger
     */
    protected function createLogger()
    {
        $log = new Logger('Aurora');
        if (isset($this->options['log']['debug'])) {
            $log->pushHandler(new StreamHandler($this->options['log']['debug'], Logger::DEBUG, false));
        }
        if (isset($this->options['log']['access'])) {
            $log->pushHandler(new StreamHandler($this->options['log']['access'], Logger::INFO, false));
        }
        if (isset($this->options['log']['error'])) {
            $log->pushHandler(new StreamHandler($this->options['log']['error'], Logger::WARNING, true));
        }

        return $log;
    }
}