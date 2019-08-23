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
    const port = '9001';
    protected $client;
    protected $service;
    public function __construct()
    {
        $this->client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on('connect', [$this, 'onConnect']);
        $this->client->on('receive', [$this, 'onReceive']);
        $this->client->on('error', [$this, 'onError']);
        $this->client->on('close', [$this, 'onClose']);
        $this->client->connect(self::ip, self::port);
        return $this;
    }

    public function onConnect()
    {
        $this->client->send("hello world\n");
    }


    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if ($name == 'service') {
            $this->service = $arguments[0];
            return $this;
        }
        $arr = [
            'service' => $this->service,
            'action' =>$name,
            'params' =>$arguments[0]?$arguments[0]:''
        ];
        $this->client->send(json_encode($arr));
    }
}

(new client())->service('GoodsService')->getGoodsList();