<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/8/23
     * Time: 16:15
     */
class client
{
    const ip = '47.97.108.227';
    const port = '90001';
    protected $client;
    public function __construct()
    {
        $this->client = $client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on('connect', [$this, 'onConnect']);
        $this->client->on('receive', [$this, 'onReceive']);
        $this->client->on('error', [$this, 'onError']);
        $this->client->on('close', [$this, 'onClose']);
        $this->client->connect(self::ip, self::port);
    }

    public function onConnect()
    {
        $this->client->send("hello world\n");
    }


    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}