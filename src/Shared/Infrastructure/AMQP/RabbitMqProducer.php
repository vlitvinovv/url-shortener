<?php

namespace App\Shared\Infrastructure\AMQP;

use App\Shared\Application\AMQP\RabbitMqProducerInterface;

class RabbitMqProducer implements RabbitMqProducerInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function publish(string $message, string $exchangeName, string $queueName, string $routingKey = '')
    {
        $this->connection->reconnect();

        $channel = $this->connection->createChannel();

        $channel->exchangeDeclare($exchangeName);
        $channel->queueDeclare($queueName);
        $channel->queueBind($queueName, $exchangeName);

        $channel->publish($message, $exchangeName, $routingKey);

        $channel->close();
        $this->connection->close();
    }
}