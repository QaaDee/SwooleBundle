<?php

namespace SwooleBundle\Command;

use App\Kernel;
use SwooleBundle\Event\OnRequest;
use SwooleBundle\Event\OnServerStart;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\HeaderBag;

class ServerCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param string $name
     */
    public function __construct(ContainerInterface $container, string $name = 'swoole:server:run')
    {
        $this->container = $container;
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $eventDispatcher = $this->container->get('event_dispatcher');

        $server = new Server(
            $this->container->getParameter('swoole.server.host'),
            $this->container->getParameter('swoole.server.port')
        );

        $server->set(
            $this->container->getParameter('swoole.server.config')
        );

        $server->on('start', static function (Server $server) use ($eventDispatcher, $output) {
            $eventDispatcher->dispatch(
                new OnServerStart($server), OnServerStart::NAME
            );
        });

        $server->on('request', static function (Request $request, Response $response) use ($eventDispatcher) {
            $eventDispatcher->dispatch(
                new OnRequest($request, $response), OnRequest::NAME
            );
        });

        $server->start();

        return 1;
    }
}

?>