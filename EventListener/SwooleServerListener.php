<?php

namespace SwooleBundle\EventListener;

use App\Kernel;
use SwooleBundle\Event\OnRequest;
use SwooleBundle\Event\OnServerStart;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class SwooleServerListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->kernel = $this->container->get('kernel');
    }

    /**
     * @param OnServerStart $onServerStart
     * @return void
     */
    public function onSwooleServerStart(OnServerStart $onServerStart)
    {

    }

    /**
     * @param OnRequest $onRequest
     * @return void
     * @throws \Exception
     */
    public function onSwooleServerRequest(OnRequest $onRequest)
    {
        $request = $onRequest->getRequest();
        $response = $onRequest->getResponse();

        $newRequest = new Request(
            $request->get ?: [],
            $request->post ?: [],
            [],
            $request->cookie ?: [],
            $request->files ?: [],
            array_merge(
                array_combine(
                    array_map(
                        'strtoupper',
                        array_keys($request->server)
                    ),
                    $request->server
                ),
                array_combine(
                    array_map(
                        'strtoupper',
                        array_keys($request->header)
                    ),
                    $request->header
                )
            ),

            $request->getContent()
        );

        $newResponse = $this->kernel->handle(
            $newRequest
        );

        $response->header = $newResponse->headers;

        $response->end(
            $newResponse->getContent()
        );
    }
}


?>