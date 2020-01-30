<?php

declare(strict_types=1);

namespace KawikaConnell\Todo;

class Input
{
    /**
     * The command, 'todo <command>'
     *
     * @var string|null
     */
    protected $command;

    /**
     * The arguments, 'todo <command> <argument_1> <argument_2>'
     *
     * @var array[int => string]
     */
    protected $arguments = [];

    /**
     * The options, 'todo <command>  -<option_1> --<option_2>'
     *
     * @var array[int => string]
     */
    protected $options = [];

    public function __construct(array $input)
    {
        $arguments       = filter($input, [self::class, 'isArgument']);
        $this->command   = head($arguments);
        $this->arguments = tail($arguments);
        $this->options   = filter($input, [self::class, 'isOption']);
    }

    public function getCommand(): ?string
    { return $this->command; }

    public function getArguments(): array
    { return $this->arguments; }

    public function getOptions(): array
    { return $this->options; }

    public static function isArgument(string $input)
    { return $input[0] != '-'; }

    public static function isOption(string $input)
    { return $input[0] == '-'; }
}