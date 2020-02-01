<?php

declare(strict_types=1);

namespace KawikaConnell\Todo\Tests\Feature;

use function KawikaConnell\Todo\main;

class AddTaskCommandTest extends TestCase
{
    public function testTellsYouItCouldntFindTheTodoFileIfItCant()
    {
        $this->expectOutputString(
            "Can't find todo.txt file in current directory ({$this->currentDirectory}). Initialize todo list first\n"
        );
        main($this->_command('add "Test Task"'));
    }
}