<?php


namespace App\Application\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    private $logger;
    private $log = [];

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->logger->info("Parameters: ", [$event->getRequest()->getContent()]);
    }
}