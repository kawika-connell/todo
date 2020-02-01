<?php

declare(strict_types=1);

namespace KawikaConnell\Todo\Tests\Feature;

use function KawikaConnell\Todo\main;
use function KawikaConnell\Todo\todoFilePath;

class AddCommandTest extends TestCase
{
    public function testTellsYouItCouldntFindTheTodoFileIfItCant()
    {
        $this->expectOutputString(
            "Can't find todo.txt file in current directory ({$this->currentDirectory}). Initialize todo list first\n"
        );

        main($this->_command('add', 'Test Task'));
    }

    public function testTellsYouWhatTaskWasAddedOnWhatLine()
    {
        $task = "Test Task";
        main($this->_command('init', '-q'));

        $this->expectOutputString(
            "Added task \"{$task}\" to ".todoFilePath($this->currentDirectory)." on line 1\n".
            "Added task \"{$task}\" to ".todoFilePath($this->currentDirectory)." on line 2\n"
        );

        main($this->_command('add', $task));
        main($this->_command('add', $task));

        $this->assertEquals(
            $task."\n".$task."\n",
            file_get_contents(todoFilePath($this->currentDirectory))
        );
    }
}