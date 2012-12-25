<?php

namespace ctrl;

use framework\dispatcher\ShellRequestDispatcher;

class MemcacheCtrl
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
        $socket->setProtocol(new \socket\Memcache());
        $socket->run();
    }


}
