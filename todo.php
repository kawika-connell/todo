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
    file_put_contents('todo.txt', '');
    echo "Created todo.txt in {$currentDirectory}";
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

    case '':
        break;

    default:
        echo "Command unknown";
        break;
}

echo "\n";
