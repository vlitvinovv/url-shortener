<?php

namespace App\Shared\Infrastructure\AMQP;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    private ?AMQPStreamConnection $amqpStreamConnection = null;

    public function __construct(
        private readonly string $host,
        private readonly string $port,
        private readonly string $user,
        private readonly string $password,
        private readonly string $vhost
    )
    {
        $this->amqpStreamConnection = $this->createConnection();
    }

    private function createConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->password,
            $this->vhost
        );
    }

    public function reconnect()
    {
        $this->amqpStreamConnection->reconnect();
    }

    public function createChannel(int $channelId = null): Channel
    {
        $channel = $this->amqpStreamConnection->channel($channelId);

        return new Channel($channel);
    }

    /**
     * @throws \Exception
     */
    public function close(): void
    {
        $this->amqpStreamConnection->close();
    }
}