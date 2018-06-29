<?php

require __DIR__ . '/../vendor/autoload.php';

$cmd = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php good 5';
$cmd1 = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php good 2';
$cmd2 = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php error 1'; // error

$commands = [$cmd, $cmd1, $cmd2];
for($i=0; $i< 150; $i++) {
    $commands[] = $cmd1;
}

$adapter = new \Pasync\Adapter\RedisAdapter();
$command = new \Pasync\Command\Command($adapter);

$start = microtime(true);
// Without ->done(), no wait for the results
// $command->exec($commands);
$command->exec($commands)->done(function ($res) {
    echo "Good :\n";
    var_dump($res);
},
    function ($error) use($start) {
        echo "Error:\n";
        var_dump($error);
        echo "Process time: " . (microtime(true) - $start) . "s\n";
    }
);


