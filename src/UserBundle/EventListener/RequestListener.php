<?php

namespace UserBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use UserBundle\Manager\AuthenticateService;

class RequestListener
{
    /**
     * @var AuthenticateService
     */
    private $authenticateService;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(AuthenticateService $authenticateService, RouterInterface $router)
    {
        $this->authenticateService = $authenticateService;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $route = $this->authenticateService->redirectFunct($event->getRequest()->get('_route'));
        if (!is_null($route)) {
            $response = new RedirectResponse($this->router->generate($route));
            $event->setResponse($response);
        }
    }
}
