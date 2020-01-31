<?php

namespace KawikaConnell\Todo;

require __DIR__.'/vendor/autoload.php';

if(!defined("STDIN")) {
    define("STDIN", fopen('php://stdin','rb'));
}

const TODO_VERSION = '0.1.0';

const COMMAND_INDEX = '';
const COMMAND_INDEX_MESSAGE = <<<DOC
Todo CLI - Version 0.1.0

Usage:
  command [options] [arguments]

  Options:                                                                                                                                                                                                        
    -h, --help     Display this help message
    -q, --quiet    Do not output any message
    -V, --version  Display this application version
    -g, --global   Run operation globally

  Available commands:
    init  Creates a todo list in the current directory
DOC;

/**
 * Command used to initialize todo list.
 */
const    COMMAND_INIT = 'init';
function command_init(Input $input) {
    openTodoFile(getcwd())->fwrite('');
    echo "Created todo.txt in {$currentDirectory}";
}

const    COMMAND_ADD = 'add';
function command_add(Input $input) {
    if (!todoFileExists(getcwd())) {
        $cwdir = cwdir();
        echo "Can\'t find todo.txt file in current directory ({$cwdir})";
    }

    $arguments = $input->getArguments();

    $task = $arguments[0];

    $todoFile = openTodoFile(getcwd(), 'a+');
    $lastLine = 0;
    $lastLineContents = '';
    foreach ($todoFile as $lineNumber => $line) {
        $lastLine = $lineNumber;
        $lastLineContents = $line;
    }
    $lastLine++;

    if ($lastLineContents !== "") {
        $todoFile->fwrite("\n");
        $lastLine++;
    }

    $todoFile->fwrite($task."\n");

    echo "Added task \"$task\" on line {$lastLine}";
}

$input = new Input(tail($argv));
$command = $input->getCommand() ?? COMMAND_INDEX;

switch ($command) {
    case COMMAND_INDEX:
        echo COMMAND_INDEX_MESSAGE;
        break;

    case COMMAND_INIT:
        command_init($input);
        break;

    case COMMAND_ADD:
        command_add($input);
        break;

    case '':
        break;

    default:
        echo "Command unknown";
        break;
}

echo "\n";
