<?php

// Freeman Yam

namespace Pasync\Tests\TestCase\Command;

use Pasync\Tests\TestAsset\Adapter\RedisAdapterMock;
use Pasync\Tests\TestAsset\Command\CommandMock;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    /** @var CommandMock */
    protected $command;

    protected function setup()
    {
        $this->command = new CommandMock(new RedisAdapterMock());
    }

    /**
     * @group command
     */
    public function testExec()
    {
        $commands = [
            'php -r "echo 1;"',
            'php -r "echo 2;"',
            'php -r "echo 3;"',
        ];

        $this->command->exec($commands);

        $ids = $this->command->getIds();
        $this->assertCount(count($commands), $ids);

        $cmds = $this->command->getCommands();
        $this->assertCount(count($commands), $cmds);
    }
}