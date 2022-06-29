<?php

namespace App\Shared\Infrastructure\Command;

use App\Shared\Infrastructure\AMQP\Connection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPIOException;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractConsumerCommand extends Command
{
    protected int $timeout = 60;
    protected int $reconnectTimeout = 10;
    protected bool $reconnect = true;

    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct();
    }

    protected function consume(string $queueName, $callback)
    {
        while ($this->reconnect) {
            try {
                $this->connection->reconnect();
                $channel = $this->connection->createChannel();

                $channel->queueDeclare($queueName);
                $channel->setBasicQos(0, 1);
                $channel->consume($queueName, $callback);

                while ($channel->isConsuming()) {
                    $channel->wait($this->timeout);
                }
            } catch (AMQPTimeoutException $e) {
                $this->reconnect = false;
                echo $e->getMessage().PHP_EOL;
                $this->cleanupConnection();
            } catch (AMQPRuntimeException $e) {
//                $msg = 'AMQPRuntimeException: '.$e->getMessage();
//                $this->logger->critical($msg);
                $this->cleanupConnection();
                sleep($this->reconnectTimeout);
            } catch (AMQPIOException $e) {
//                $msg = 'AMQPIOException: '.$e->getMessage();
//                $this->logger->critical($msg);
                $this->cleanupConnection();
                sleep($this->reconnectTimeout);
            }
        }
    }

    protected function cleanupConnection()
    {
        try {
            $this->connection->close();
        } catch (\ErrorException $e) {
        }
    }
}
