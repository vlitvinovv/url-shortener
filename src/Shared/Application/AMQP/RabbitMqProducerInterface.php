<?php

namespace App\Shared\Application\AMQP;

interface RabbitMqProducerInterface
{
    public function publish(string $message, string $exchangeName, string $queueName, string $routingKey = '');
}