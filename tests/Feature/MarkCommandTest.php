<?php

declare(strict_types=1);

namespace KawikaConnell\Todo\Tests\Feature;

use function KawikaConnell\Todo\main;
use function KawikaConnell\Todo\todoFilePath;

class MarkCommandTest extends TestCase
{
    public function testTellsYouItCouldntFindTheTodoFileIfItCant()
    {
        $this->expectOutputString(
            "Can't find todo.txt file in current directory ({$this->currentDirectory}). Initialize todo list first\n"
        );

        main($this->_command('list'));
    }

    public function testMarksTask()
    {
        main($this->_command('init', '-q'));
        main($this->_command('add', 'First Task',  '-q'));

        $this->expectOutputString("Marked task on line 1 as [done]\n");

        main($this->_command('mark', '1', 'done'));
        
        $this->assertEquals(
            "[done] First Task\n",
            file_get_contents(todoFilePath($this->currentDirectory))
        );
    }
}