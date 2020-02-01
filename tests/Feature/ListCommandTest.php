<?php

declare(strict_types=1);

namespace KawikaConnell\Todo\Tests\Feature;

use function KawikaConnell\Todo\main;
use function KawikaConnell\Todo\todoFilePath;

class ListCommandTest extends TestCase
{
    public function testTellsYouItCouldntFindTheTodoFileIfItCant()
    {
        $this->expectOutputString(
            "Can't find todo.txt file in current directory ({$this->currentDirectory}). Initialize todo list first\n"
        );

        main($this->_command('list'));
    }

    public function testListsAllTasks()
    {
        main($this->_command('init', '-q'));
        main($this->_command('add', 'First Task',  '-q'));
        main($this->_command('add', 'Second Task', '-q'));
        main($this->_command('add', 'Third Task',  '-q'));

        $this->expectOutputString(
            "Tasks in ".todoFilePath($this->currentDirectory).":\n".
            "1. First Task\n".
            "2. Second Task\n".
            "3. Third Task\n\n"
        );

        main($this->_command('list'));
    }
}