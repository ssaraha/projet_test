<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

use Symfony\Component\Security\Core\Security;

class LogouteventSubscriber implements EventSubscriberInterface
{

    private $urlGenerator;
    private $flashBag;
    private $security;

    public function __construct(UrlGeneratorInterface $urlGenerator,
                                FlashBagInterface $flashBag,
                                Security $security
                                )
    {
        
        $this->urlGenerator = $urlGenerator;
        $this->flashBag = $flashBag;
        $this->security = $security;
    }

    public function onLogoutEvent(LogoutEvent $event)
    {
        //dd($event->getRequest()->getSession());
        //$event->getRequest()->getSession()->getFlashBag('success', 'Vous êtes déconnectés');

        $this->flashBag->add(
                'success',
                $this->security->getUser()->getFullName().' vous êtes deconnectés avec succes '
                //$event->getToken()->getUser()->getFullName().' vous êtes deconnectés avec succes '//Recuperation user via Token
                );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('home_page')));
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
