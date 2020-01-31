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
    $currentDirectory = getcwd();

    if (todoFileExists($currentDirectory)) {
        echo "todo.txt already exists in {$currentDirectory}";
        return;
    }

    openTodoFile($currentDirectory)->fwrite('');
    echo "Created todo.txt in {$currentDirectory}";
}

/**
 * Command used to add a task to a todo list.
 */
const    COMMAND_ADD = 'add';
function command_add(Input $input) {
    $currentDirectory = getcwd();

    if (!todoFileExists($currentDirectory)) {
        echo "Can't find todo.txt file in current directory ({$currentDirectory}). Initialize todo list first";
        return;
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

    if ($lastLineContents != "") {
        $todoFile->fwrite("\n");
        $lastLine++;
    }

    $todoFile->fwrite($task."\n");

    echo "Added task \"$task\" to ".todoFilePath($currentDirectory)." on line {$lastLine}";
}

/**
 * Command used to see all tasks in todo list.
 */
const    COMMAND_LIST = 'list';
function command_list(Input $input) {
    $currentDirectory = getcwd();
    if (!todoFileExists($currentDirectory)) {
        echo "Can't find todo.txt file in current directory ({$currentDirectory}). Initialize todo list first.";
        return;
    }

    $todoFile = openTodoFile($currentDirectory);

    if ($todoFile->getSize() == 0) {
        echo "Your todo list is empty";
        return;
    }

    echo 'Tasks in '.todoFilePath($currentDirectory).":\n";
    foreach ($todoFile as $lineNumber => $line) {
        if ($line == "") {
            continue;
        }

        $lineNumber++;
        echo "{$lineNumber}: {$line}";
    }
}

$input = new Input(tail($argv));
$command = $input->getCommand() ?? COMMAND_INDEX;

switch ($command) {
    case COMMAND_INDEX:
        echo COMMAND_INDEX_MESSAGE;
        break;

    case COMMAND_INIT:
        command_init($input);
        echo "\n";
        break;

    case COMMAND_ADD:
        command_add($input);
        echo "\n";
        break;

    case COMMAND_LIST:
        command_list($input);
        break;

    case '':
        break;

    default:
        echo "Command unknown";
        break;
}
