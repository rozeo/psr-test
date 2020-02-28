<?php

use PHPUnit\Framework\TestCase;

use Rozeo\Psr7\Request;

class RequestTest extends TestCase
{
    public function test_RequestTarget()
    {
        $target = "target";

        $request = new Request();
        $request->withRequestTarget($target);

        $this->assertEquals($request->getRequestTarget(), $target);
    }

    public function test_Method()
    {
        $method = "POST";

        $request = new Request();
        $request->withMethod($method);

        $this->assertEquals($request->getMethod(), $method);
    }

    public function test_Uri()
    {
        $uri = "/hoge/fuga";
        $request = new Request();
        $request->withUri($uri);

        $this->assertEquals($request->getUri(), $uri);
    }
}
