<?php

namespace App\Analytic\Infrastructure\Command;

use App\Analytic\Application\Command\AddLinkViewCommand;
use App\Shared\Infrastructure\AMQP\Connection;
use App\Shared\Infrastructure\Bus\CommandBus;
use App\Shared\Infrastructure\Command\AbstractConsumerCommand;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LinkViewConsumerCommand extends AbstractConsumerCommand
{
    use LockableTrait;

    private const QUEUE_NAME = 'link_view';

    public function __construct(
        Connection $connection,
        private    readonly SerializerInterface $serializer,
        private    readonly CommandBus $commandBus
    )
    {
        parent::__construct($connection);
    }

    protected function configure()
    {
        $this
            ->setName('app:consume:link-view')
            ->setDescription('Consuming link views');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('Can not acquire lock, process is already running.');

            return 0;
        }

        $callback = function (AMQPMessage $message) use ($output) {
            $output->writeln('Received ' . $message->body . PHP_EOL);

            $command = $this->serializer->deserialize($message->body, AddLinkViewCommand::class, 'json');
            $this->commandBus->execute($command);

            $channel = $message->getChannel();
            $channel->basic_ack($message->getDeliveryTag());
        };

        $this->consume(self::QUEUE_NAME, $callback);

        $this->release();

        return Command::SUCCESS;
    }
}