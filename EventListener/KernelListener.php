<?php

namespace SwooleBundle\EventListener;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\AbstractManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class KernelListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var AbstractManagerRegistry
     */
    protected $doctrine;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine', ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    public function onKernelRequest(RequestEvent $requestEvent)
    {
        if($this->doctrine) {
            /**
             * @var $connection Connection
             */
            foreach ($this->doctrine->getConnections() as $connection) {
                if($connection->isConnected()) {
                    if(!$connection->ping()) {
                        $connection->close();
                        $connection->connect();
                    }
                }
            }
        }

    }

    /**
     * @param ResponseEvent $responseEvent
     * @return void
     */
    public function onKernelResponse(ResponseEvent $responseEvent)
    {
        if($this->doctrine) {
            foreach ($this->doctrine->getManagers() as $manager) {
                $manager->clear();
            }
        }
    }
}

?>