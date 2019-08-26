<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/8/23
     * Time: 16:15
     */
spl_autoload_register(function ($class) {
    include_once __DIR__.'/service/' . $class .'.php';
});
class server
{
    const ip   = '0.0.0.0';
    const port = '9002';
    protected $server;
    public function __construct()
    {
        $this->server = new Swoole\Server(self::ip, self::port, SWOOLE_BASE, SWOOLE_SOCK_TCP);
        $this->server->set(array(
            'worker_num' => 8,
            'daemonize' => 0,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1,
        ));
        $this->server->on('Connect', [$this, 'onConnect']);
        $this->server->on('Receive', [$this, 'onReceive']);
        $this->server->on('Close', [$this, 'onClose']);
        $this->server->start();

    }

    public function onConnect($serv, $fd)
    {
//        echo '用户'.$fd.'连接进来了';
    }

    public function onReceive($serv, $fd, $reactor_id, $data)
    {
        $arr = json_decode($data, true);
        $className = $arr['service'];
        $action = $arr['action'];
        $param = $arr['params'];
        $obj = new $className;
        $return_data = $obj->$action($param);
        $serv->send($fd, 'Swoole: '.json_encode($return_data));
        $serv->close($fd);
    }

    public function onClose($serv, $fd)
    {
        //echo '用户'.$fd.'关闭了连接';
    }

}

new server();
