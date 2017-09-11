<?php

namespace NotificationsClientBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestNotifyCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:notify')
            ->setDescription('Test notifications Client')
            ->addArgument('clientUserId')
            ->addArgument('messageKey')
            ->addArgument('message')
            ->addArgument('notificationType');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $service = $this->getContainer()->get('notifications');
        $service->notify($input->getArgument('clientUserId'), $input->getArgument('messageKey'), $input->getArgument('message'), $input->getArgument('notificationType'));

    }
}
