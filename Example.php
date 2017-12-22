<?php

namespace Hanson\MyVbot;

use Hanson\Vbot\Foundation\Vbot as Bot;
use Vbot\Blacklist\Blacklist;
use Vbot\GuessNumber\GuessNumber;
use Vbot\HotGirl\HotGirl;
use Vbot\Tuling\Tuling;

class Example
{
    private $config;

    public function __construct($session = null)
    {
        $this->config = require_once __DIR__ . '/config.php';

        if ($session) {
            $this->config['session'] = $session;
        }
    }

    public function run()
    {
        $robot = new Bot($this->config);
        // 获取消息处理器实例
        $messageHandler = $robot->messageHandler;

        // 收到消息时触发
        $messageHandler->setHandler([MessageHandler::class, 'messageHandler']);

        // 一直触发
        $messageHandler->setCustomHandler(function () {
            if (date('H') == 12) {
                Text::send('filehelper', '现在时间 12 点');
            }
        });
        $robot->messageExtension->load([
            // some extensions
           // Tuling::class
        ]);

        $robot->observer->setQrCodeObserver([Observer::class, 'setQrCodeObserver']);

        $robot->observer->setLoginSuccessObserver([Observer::class, 'setLoginSuccessObserver']);

        $robot->observer->setReLoginSuccessObserver([Observer::class, 'setReLoginSuccessObserver']);

        $robot->observer->setExitObserver([Observer::class, 'setExitObserver']);

        $robot->observer->setFetchContactObserver([Observer::class, 'setFetchContactObserver']);

        $robot->observer->setBeforeMessageObserver([Observer::class, 'setBeforeMessageObserver']);

        $robot->observer->setNeedActivateObserver([Observer::class, 'setNeedActivateObserver']);

        $robot->server->serve();
    }
}
