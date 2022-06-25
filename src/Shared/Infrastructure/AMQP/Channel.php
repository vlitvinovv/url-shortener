<?php

namespace App\Shared\Infrastructure\AMQP;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Channel
{
    public AMQPChannel $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function queueDeclare(string $queueName)
    {
        $this->channel->queue_declare(
            $queueName,
            false,
            true,
            false,
            false
        );
    }

    public function exchangeDeclare(string $exchangeName)
    {
        $this->channel->exchange_declare(
            $exchangeName,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false,
            false,
            false
        );
    }

    public function queueBind(string $queueName, string $exchangeName, string $routingKey = '')
    {
        $this->channel->queue_bind(
            $queueName, $exchangeName, $routingKey
        );
    }

    public function setBasicQos($size = 0, $count = 1)
    {
        return $this->channel->basic_qos(
            $size,
            $count,
            false
        );
    }

    public function publish(
        string $message,
        string $exchangeName,
        string $routingKey = ''
    ): void {
        $amqpMessage = new AMQPMessage(
            $message,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $this->channel->basic_publish(
            $amqpMessage,
            $exchangeName,
            $routingKey
        );
    }

    public function consume(string $queueName, callable $callback)
    {
        $this->channel->basic_consume(
            $queueName,
            '',
            false,
            false,
            false,
            false,
            $callback
        );
    }

    public function isConsuming(): bool
    {
        return $this->channel->is_consuming();
    }

    public function wait($timeout)
    {
        $this->channel->wait(null, false, $timeout);
    }

    public function close(): void
    {
        $this->channel->close();
    }
}