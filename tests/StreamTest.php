<?php

use PHPUnit\Framework\TestCase;

use Rozeo\Psr7\Stream;

class StreamTest extends TestCase
{
    public function setUp(): void
    {
    
    }

    public function test_ConvertableInstaceToString()
    {
        $stream = new Stream();

        $this->assertIsString((string)$stream);
    }

    public function test_Writable()
    {
        $stream = new Stream();

        $str = "123456789";
        
        $this->assertTrue(strlen($str) === $stream->write($str));
    }

    public function test_CorrectWritedString()
    {
        $stream = new Stream();

        $str = "123456789";

        $stream->write($str);

        $this->assertTrue($str === (string)$stream);
    }

    public function test_Seekable()
    {
        $stream = new Stream();

        $str = "123456789";

        $stream->write($str);

        $stream->seek(1);

        $this->assertTrue($stream->tell() === 1);
    }

    public function test_SeekCur()
    {
        $stream = new Stream();
        $str = "12345";
        $stream->write($str);

        $stream->seek(-5, SEEK_CUR);

        $this->assertTrue($stream->tell() === 0);
    }

    /**
     * @expectedException RuntimeException
     */
    public function test_SeekCurExceptionWithOverOffset()
    {
        $stream = new Stream();
        $str = "123456";
        $stream->write($str);

        $stream->seek(1, SEEK_CUR);
    }

    /**
     * @expectedException RuntimeException
     */
    public function test_SeekCurExceptionWithUnderZero()
    {
        $stream = new Stream();
        $str = "123456";
        $stream->write($str);

        $stream->seek(-strlen($str) - 1, SEEK_CUR);
    }

    public function test_Read()
    {
        $stream = new Stream();

        $str = "123456789";

        $stream->write($str);
        $stream->seek(0);

        $this->assertTrue($str === $stream->read(strlen($str)));
    }

    public function test_OverwriteStream()
    {
        $str1 = "123456";
        $str2 = "000000";

        $stream = new Stream();

        $stream->write($str1);
        $stream->seek(1);
        $stream->write($str2);

        $this->assertTrue(
            (string)$stream === "1000000"
        );
    }
}
