<?php

namespace Rozeo\Psr7;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

use InvalidArgumentException;

class Message implements MessageInterface
{
    /**
     * @var string http protocol version string
     */
    private $protocolVersion;


    /**
     * @var string[][] http header string array  
     */
    private $headers;

    /**
     * @var Psr\Http\Message\StreamInterface http body
     */
    private $body;

    protected function __construct()
    {
        $this->protocolVersion = "1.0";
        $this->headers = [];
        $this->body = null;
    }

    /**
     * get http protocol version string
     * @return string
     */
    protected function getProtocolVersion()
    {
        return $this->protocolVersion;    
    } 

    /**
     * set http protocol version string
     *
     * @param string $version HTTP protocol version
     * @return $this
     */
    protected function withProtocolVersion(string $version)
    {
        $this->protocolVersion = $version;
        return $this;
    }

    protected function getHeaders()
    {
        return $this->headers;
    }

    protected function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }

    protected function getHeader(string $name): array
    {
        return $this->headers[$name] ?? [];
    }

    protected function getHeaderLine(string $name): string
    {
        return join(",", $this->getHeader($name));
    }

    protected function withHeader(string $name, $value): self
    {
        if (is_array($value)) {
            $this->headers[$name] = array_map("strval", $value);
        } elseif (is_string($value)) {
            $this->headers[$name] = [$value];
        } else {
            throw new InvalidArgumentException("$value is not string|string[].");
        }

        return $this;
    }

    protected function withAddedHeader(string $name, $value): self
    {
        if (is_array($value)) {
            $this->headers[$name] = array_merge($this->headers, array_map("strval", $value));
        } elseif (is_string($value)) {
            $this->headers[$name][] = $value;
        } else {
            throw new InvalidArgumentException("$value is not string|string[]");
        }
    }

    protected function withoutHeader(string $name): self
    {
        unset($this->headers[$name]);
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): self
    {
        $this->body = $body;
        return $this;
    }
}
