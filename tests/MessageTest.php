<?php

use PHPUnit\Framework\TestCase;

use Rozeo\Psr7\Message;

class MessageTest extends TestCase
{
    public function setUp(): void
    {
    
    }

    public function test_ProtocolVersion()
    {
        $message = new Message();

        $version = "1.1";

        $message->withProtocolVersion($version);

        $this->assertTrue($message->getProtocolVersion() === $version);
    }

    public function test_HasHeader()
    {
        $message = new Message();

        $name = "test";
        $value = "value1";

        $message->withHeader($name, $value);

        $this->assertTrue($message->hasHeader($name));
    }

    public function test_SetHeaderWithString()
    { 
        $message = new Message();

        $name = "test";
        $value = "value1";

        $message->withHeader($name, $value);

        $this->assertEquals($message->getHeader($name), [$value]);
    }


    public function test_SetHeaderWithArray()
    { 
        $message = new Message();

        $name = "test";
        $value = ["value1", "value2"];

        $message->withHeader($name, $value);

        $this->assertEquals($message->getHeader($name), $value);
    }

    public function test_GetHeaderLine()
    { 
        $message = new Message();

        $name = "test";
        $value = ["value1", "value2"];

        $message->withHeader($name, $value);

        $this->assertEquals($message->getHeaderLine($name), "value1,value2");
    }

    public function test_SetHeaderWithUnexpectedTypeValue()
    {
        $this->expectException(InvalidArgumentException::class);

        $message = new Message(); 
        $name = "test111";
        $value = new Message();

        $message->withHeader($name, $value);
    }

    public function test_AddHeaderWithString()
    { 
        $message = new Message();

        $name = "test";
        $value1 = "value1";
        $value2 = "value2";

        $message->withHeader($name, $value1)
                ->withAddedHeader($name, $value2);

        $this->assertEquals($message->getHeader($name), [$value1, $value2]);
    }

    public function test_AddHeaderWithArray()
    {
        $name = "test123";
        $value1 = ["value1", "value2"];
        $value2 = ["value3", "value4"];

        $message = new Message();

        $message->withHeader($name, $value1)
            ->withAddedHeader($name, $value2);

        $this->assertEquals($message->getHeader($name), array_merge($value1, $value2));
    }

    public function test_AddHeaderWithUnexpectedValueType()
    {
        $this->expectException(InvalidArgumentException::class);

        $message = new Message();
        $value = new Message();

        $message->withHeader("test1", "123")
            ->withAddedHeader("test1", $value);
    }

    public function test_AddHeaderWithUnRegisteredHeaderName()
    {
        $message = new Message();

        $name = "name1";
        $value = ["value1"];
        $message->withAddedHeader($name, $value);

        $this->assertEquals($message->getHeader($name), $value);
    }

    public function test_WithoutHeader()
    {
        $message = new Message();
        $name = "test12345";

        $message->withHeader($name, "12345213");
        $message->withoutHeader($name);

        $this->assertTrue($message->hasHeader($name) === false);
    }

    public function test_MultiHeaderCheck()
    {
        $message = new Message();
        $name1 = "test2312";
        $value1 = ["abc", "def"];
        $name2 = "test1231";
        $value2 = "abcd";

        $message->withHeader($name1, $value1)
            ->withHeader($name2, $value2);

        $this->assertEquals($message->getHeaders(), [
            $name1 => $value1,
            $name2 => [$value2],
        ]);
    }

    public function test_SetStreamBody()
    {
        $message = new Message();
        $stream = new Rozeo\Psr7\Stream();

        $stream->write(12345);

        $message->withBody($stream);

        $this->assertEquals($message->getBody(), $stream);
    }
}
