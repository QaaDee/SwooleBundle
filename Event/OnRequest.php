<?php

namespace SwooleBundle\Event;

use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

class OnRequest
{
    const NAME = 'swoole.server.request';

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return OnRequest
     */
    public function setRequest(Request $request): OnRequest
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return OnRequest
     */
    public function setResponse(Response $response): OnRequest
    {
        $this->response = $response;
        return $this;
    }
}

?>