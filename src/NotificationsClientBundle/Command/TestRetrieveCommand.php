<?php

namespace NotificationsClientBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestRetrieveCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:retrieve')
            ->setDescription('Test retrieval of notifications')
            ->addArgument('clientUserId')
            ->addArgument('status');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $this->getContainer()->get('notifications');
        $messages = $service->getMessages($input->getArgument('status'), $input->getArgument('clientUserId'));

        dump($messages);
    }
}
