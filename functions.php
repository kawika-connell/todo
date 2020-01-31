<?php

declare(strict_types=1);

namespace KawikaConnell\Todo;

use SplFileObject;

use Closure;

/**
 * Let's you chain single-parameter functions together.
 * ```
 * > compose('strtoupper', 'str_split')('hello') == str_split(strtoupper('hello'))
 * ```
 *
 * @param [array => callable] $callables
 */
function compose(...$callables): Closure {
    return function($input) use ($callables) {
        foreach ($callables as $callable) {
            $input = $callable($input);
        }
        return $input;
    };
}

/**
 * Resets array numerical key count on an array.
 * ```
 * > reindex([1 => 'one', 2 => 'two', 3 => 'three']);
 * [0 => 'one', 1 => 'two', 2 => 'three']
 * ```
 */
function reindex(array $array): array {
    $returnNonAssoc = [];
    $returnAssoc = [];
    foreach ($array as $key => $element) {
        if (is_string($key)) {
            $returnAssoc[$key] = $element;
            continue;
        }

        $returnNonAssoc[] = $element;
    }

    return $returnNonAssoc + $returnAssoc;
}

/**
 * Return the first element of an array.
 * ```
 * > tail(['one', 'two', 'three']);
 * ['two', 'three']
 * ```
 *
 * @return mixed
 */
function head(array $array) {
    return array_shift($array);
}

/**
 * Return the array minus its first element.
 * ```
 * > tail(['one', 'two', 'three']);
 * ['two', 'three']
 * ```
 */
function tail(array $array): array {
    array_shift($array);
    return $array;
}

function formatPath(string $directory) {
    return str_replace('/', DIRECTORY_SEPARATOR, $directory);
}

/**
 * array_filter, but it doesn't preserve numerical keys.
 * ```
 * > filter(['one', 2, 3.0, '4'], 'is_string');
 * [0 => 'one', 1 => '4']
 * ```
 */
function filter(array $array, callable $callable): array {
    return reindex(array_filter($array, $callable));
}

function todoFilePath(string $directory) {
    return formatPath("{$directory}/todo.txt");
}

function todoFileExists(string $directory) {
    return file_exists(todoFilePath($directory));
}

function openTodoFile(string $directory, string $mode = 'r') {
    return new SplFileObject(todoFilePath($directory), $mode);
}