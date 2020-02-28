<?php

namespace Rozeo\Psr7;

class Request extends Message
    implements Psr\Http\Message\RequestInterface
{

    /**
     * @var string request target
     */
    private $requestTarget;

    /**
     * @var string method type
     */
    private $method;

    /**
     * @var string request uri
     */
    private $uri;
    
    /**
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->requestTarget;
    } 

    /**
     * @param string request target
     * @return $this
     */
    public function withRequestTarget($requestTarget)
    {
        $this->requestTarget = $requestTarget;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function withUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}