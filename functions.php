<?php

declare(strict_types=1);

namespace KawikaConnell\Todo;

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

function reIndex(array $array): array {
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
 *
 */
function tail(array $array): array {
    array_shift($array);
    return $array;
}

function filter(array $array, callable $callable): array {
    return reIndex(array_filter($array, $callable));
}