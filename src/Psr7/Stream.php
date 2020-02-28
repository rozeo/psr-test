<?php

namespace Rozeo\Psr7;

use Psr\Http\Message\StreamInterface;

use RuntimeException;

class Stream implements StreamInterface
{
    /**
     * @var string stream body
     */
    private $stream;


    /**
     * @var int current stream offset
     */
    private $offset;

    /**
     * @var int current stream size
     */
    private $size;

    public function __construct()
    {
        $this->stream = "";
        $this->offset = 0;
    }

    public function __toString()
    {
        return $this->stream;
    }

    public function close()
    {
    }

    public function detach()
    {
        return null;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function tell()
    {
        return $this->offset;
    }

    public function eof(): bool
    {
        return $this->offset >= $this->getSize();
    }

    public function isSeekable(): bool
    {
        return true;
    }

    public function seek($offset, $whence = \SEEK_SET)
    {
        $nextOffset = 0;
        switch($whence)
        {
        case SEEK_SET:
            $nextOffset = $offset;
            break;

        case SEEK_CUR:
            $nextOffset = $this->offset + $offset;
            break;

        case SEEK_END:
            $nextOffset = $this->getSize() - $offset;
            break;

        default:
            throw new RuntimeException("Invalid whence option.");
        }    
        
        if ($nextOffset > $this->getSize() || $nextOffset < 0) {
            throw new RuntimeException("offset[$nextOffset] is out of range.");
        }

        $this->offset = $nextOffset;

        return $this;
    }

    public function rewind()
    {
        $this->seek(0);
        return $this;
    }

    public function isWritable()
    {
        return true;
    }

    public function write($string)
    {
        if (!$this->isWritable()) {
            return 0;
        }

        $length = strlen($string);
        
        $this->stream = substr_replace($this->stream, $string, $this->offset, $length);
        $this->offset += $length;
        $this->size = strlen($this->stream);

        return $length;
    }

    public function isReadable()
    {
        return true;
    }

    public function read($length)
    {
        if (!$this->isReadable()) {
            return "";
        }

        return substr($this->stream, $this->offset, $length);
    }

    public function getContents()
    {
        return substr($this->stream, $this->offset);
    }

    public function getMetadata($key = null)
    {
        return null;
    }
}
