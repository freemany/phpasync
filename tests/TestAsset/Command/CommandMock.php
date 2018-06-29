<?php

// Freeman Yam

namespace Pasync\Tests\TestAsset\Command;

use Pasync\Command\Command;

class CommandMock extends Command
{
     public function getCmdTpl(): string
     {
         return $this->cmdTpl;
     }

     public function getCommands(): array
     {
         return $this->commands;
     }

     public function getIds(): array
     {
         return $this->ids;
     }
}