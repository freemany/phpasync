<?php
// Freeman Yam

namespace Pasync\Command;

use Pasync\Adapter\AdapterInterface;

class Command
{
    protected $adapter;
    protected $max = 5000;
    protected $ids;
    protected $cmdTpl = '%s %s > /dev/null 2>&1 &';
    protected $commands = [];
    protected $goodResponse = [];
    protected $errResponse = [];
    protected $done = false;
    protected $result;

    /**
     * Command constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param array $commands
     *
     * @return Command
     */
    public function exec(array $commands): self
    {
        foreach ($commands as $command) {
            $id = uniqid('command_thread_');
            $this->ids[] = $id;
            $this->commands[$id] = $command;
            $this->run($id, $command);
        }
        return $this;
    }

    /**
     * @param \Closure      $callback
     * @param \Closure|null $errHandler
     *
     * @return bool
     */
    public function done(\Closure $callback, \Closure $errHandler = null): bool
    {
        $i = 0;
        while ($this->done === false) {
            $i++;
            $count = 0;
            foreach ($this->ids as $id) {
                $res = $this->adapter->get($id);

                $res = json_decode($res, true);
                if (null !== $res && isset($res['done'])) { $count ++;
                    if (true === $res['done']) {
                        $this->goodResponse[$id] = $res['response'];
                    } elseif (false === $res['done'] && isset($res['error'])) {
                        $this->errResponse[$id] = $res['error'];
                    }
                }
            }

            if (count($this->ids)  ===  $count) {
                $good = [];
                $err = [];
                foreach ($this->ids as $id) {
                    $good[] = $this->goodResponse[$id] ?? null;
                    $err[] = $this->errResponse[$id] ?? null;
                    $this->adapter->del($id);
                }

                echo "done\n";
                call_user_func($callback, $good);
                if (is_callable($errHandler)) {
                    $err = count($this->errResponse) ? $err : null;
                    call_user_func($errHandler, $err);
                }
                $this->done = true;
            }

            if ($i > $this->max) {
                foreach ($this->ids as $id) {
                    $this->adapter->del($id);
                    echo "fail\n";
                    $this->done = true;
                    return false;
                }
            }
        }

        return true;
    }

    protected function run($id, $command): void
    {
        $cmd = sprintf($this->cmdTpl, $command, $id);
        shell_exec($cmd);
    }
}