<?php

require __DIR__ . '/../vendor/autoload.php';

$cmd = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php good 1';
$cmd1 = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php good 5'; // error
$cmd2 = '/usr/bin/php /Users/freemanyam/Sites/sb/phpasync/examples/thread.php error 5'; // error

$commands = [$cmd, $cmd1, $cmd2];
for($i=0; $i< 150; $i++) {
    $commands[] = $cmd1;
}

$adapter = new \Pasync\Adapter\RedisAdapter();
$command = new \Pasync\Command\Command($adapter);

$start = microtime(true);
$command->exec($commands)->done(function ($res) {
    echo "Good :\n";
    var_dump($res);
},
    function ($error) use($start) {
        echo "Error:\n";
        var_dump($error);
        var_dump((microtime(true) - $start));
    }
);


