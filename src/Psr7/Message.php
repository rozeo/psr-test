<?php

namespace Rozeo\Psr7;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

use InvalidArgumentException;

class Message implements MessageInterface
{
    /**
     * @var string http protocol version 
     */
    private $protocolVersion;


    /**
     * @var string[][] http header  array  
     */
    private $headers;

    /**
     * @var \Psr\Http\Message\StreamInterface|null http body
     */
    private $body;

    public function __construct()
    {
        $this->protocolVersion = "1.0";
        $this->headers = [];
        $this->body = null;
    }

    /**
     * get http protocol version 
     * @return string 
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;    
    } 

    /**
     * set http protocol version 
     *
     * @param string $version HTTP protocol version
     * @return static
     */
    public function withProtocolVersion($version)
    {
        $this->protocolVersion = $version;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name)
    {
        return $this->headers[$name] ?? [];
    }

    public function getHeaderLine($name)
    {
        return join(",", $this->getHeader($name));
    }

    public function withHeader($name, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        try {
            $this->headers[$name] = array_map("strval", $value);
        } catch(\Error $e) {
            throw new InvalidArgumentException("Unexpected value passed, value is not string|string[].");
        }

        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        if (!$this->hasHeader($name)) {
            return $this->withHeader($name, $value);
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        try {
            $value = array_map("strval", $value);
            $this->headers[$name] = array_merge($this->headers[$name], $value);

        } catch(\Error $e) {
            throw new InvalidArgumentException("Unexpected value passed, value is not string|string[]");
        }

        return $this;
    }

    public function withoutHeader($name)
    {
        unset($this->headers[$name]);
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        $this->body = $body;
        return $this;
    }
}
