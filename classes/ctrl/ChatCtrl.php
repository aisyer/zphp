<?php

namespace ctrl;

use framework\dispatcher\ShellRequestDispatcher;

class ChatCtrl
{

    /**
     *
     * 验证过滤
     * @return boolean
     * @throws common\GameException
     */
    public function beforeFilter()
    {
        if ($this->dispatcher instanceof ShellRequestDispatcher) {
            return true;
        }

        throw new \Exception('forbidden');
    }



    public function start()
    {
        $socket = new \framework\socket\Socket(HOST, PORT);
        $socket->setProtocol(new \socket\Chat());
        $socket->run();
    }

    public function new() {
        $loop = \React\EventLoop\Factory::create();
        $socket = new \React\Socket\Server($loop);

        $conns = new \SplObjectStorage();

        $socket->on('connection', function ($conn) use ($conns) {
            echo $conn->getClientAddress();
            echo $conn->getRemoteAddress();
            echo "connection\n";
            $conns->attach($conn);

            $conn->on('data', function ($data) use ($conns, $conn) {

                if('/quit' == trim($data)) {
                    $conns->detach($conn);
                    $conn->end();
                    return;
                }
                foreach ($conns as $current) {
                    if ($conn === $current) {
                        continue;
                    }

                    $current->write($data);
                }
            });

            $conn->on('end', function () use ($conns, $conn) {
                $conns->detach($conn);
            });
        });

        $port = PORT;
        $host = HOST;
        echo "Socket server listening on port {$port}.\n";
        echo "You can connect to it by running: telnet {$host} {$port}\n";

        $socket->listen($port, $host);
        $loop->run();
    }

    public function stop() {
        $deamon = new \framework\util\Daemon($GLOBALS['DAEMON_CONFIG']);
        $deamon->stop();
    }


}
