<?php

namespace KawikaConnell\Todo\Tests\Feature;

use PHPUnit\Framework\TestCase;
use KawikaConnell\Todo\Input;

class InputTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->inputArray = explode(' ', 'command argument_1 argument_2 --option_1 -o2');
        $this->input      = new Input($this->inputArray);
    }

    public function testItGetsTheCommandFromInput()
    {
        $this->assertEquals('command', $this->input->getCommand());
    }

    public function testGetCommandReturnsNullWhenNoCommandIsProvided()
    {
        $this->assertNull((new Input([]))->getCommand());
    }

    public function testItGetsTheArgumentsFromInput()
    {
        $this->assertEquals(['argument_1', 'argument_2'], $this->input->getArguments());
    }

    public function testItGetsTheOptionsFromInput()
    {
        $this->assertEquals(['--option_1', '-o2'], $this->input->getOptions());
    }
}