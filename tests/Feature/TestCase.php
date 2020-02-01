<?php

namespace KawikaConnell\Todo\Tests\Feature;

use PHPUnit\Framework\TestCase as BaseTestCase;
use KawikaConnell\Todo\Input;

use function KawikaConnell\Todo\todoFilePath;
use function KawikaConnell\Todo\formatPath;

class TestCase extends BaseTestCase
{
    /**
     * Changes working directory to {project}/tests/_state. All
     * commands (hence, filesystem changes) will be done in here.
     */
    public function setUp()
    {
        parent::setUp();
        $currentDirectory = formatPath(dirname(__DIR__).'/_state');
        $this->currentDirectory = $currentDirectory;
        chdir($this->currentDirectory);
    }

    public function tearDown()
    {
        $todoFile = todoFilePath(dirname(__DIR__).'/_state');
        if (file_exists($todoFile)) {
            unlink($todoFile);
        }
        
        parent::tearDown();
    }

    protected function _command(string $string): Input
    { return new Input(explode(' ', $string)); }
}