<?php

declare(strict_types=1);

namespace KawikaConnell\Todo\Tests\Feature;

use PHPUnit\Framework\TestCase;

use function KawikaConnell\Todo\head;
use function KawikaConnell\Todo\tail;
use function KawikaConnell\Todo\compose;

class functionsTest extends TestCase
{
    public function testHead()
    {
        $array = ['one', 'two', 'three'];
        $this->assertEquals('one', head($array));
        $this->assertEquals(['one', 'two', 'three'], $array);
    }

    public function testTail()
    {
        $array = [0 => 'one', 1 => 'two', 2 => 'three'];
        $this->assertEquals([0 => 'two', 1 => 'three'], tail($array));
        $this->assertEquals([0 => 'one', 1 => 'two', 2 => 'three'], $array);
    }

    public function testCompose()
    {
        $this->assertEquals(str_split(strtoupper('hello')), compose('strtoupper', 'str_split')('hello'));
    }
}