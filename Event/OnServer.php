<?php

namespace SwooleBundle\Event;

use OpenSwoole\Server;

abstract class OnServer
{
    const NAME = '';

    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @param Server $server
     * @return OnServer
     */
    public function setServer(Server $server): OnServer
    {
        $this->server = $server;
        return $this;
    }
}

?>