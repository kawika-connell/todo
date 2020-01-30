<?php

namespace KawikaConnell\Todo;

require __DIR__.'/vendor/autoload.php';

const COMMAND_INDEX = '';
const COMMAND_INDEX_MESSAGE = <<<DOC
Todo CLI - Version 0.1.0

Usage:
  command [options] [arguments]
DOC;

$input = new Input(tail($argv));
$command = $input->getCommand() ?? COMMAND_INDEX;

switch ($command) {
    case COMMAND_INDEX:
        echo COMMAND_INDEX_MESSAGE;
        break;

    case '':
        break;

    default:
        echo "Command unknown";
        break;
}
