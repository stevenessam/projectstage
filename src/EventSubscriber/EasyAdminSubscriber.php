<?php

namespace App\Entity\EventSubscriber;

use DateTime;
use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;
    public function __construct (SluggerInterface $slugger,Security $security)
    {
    
        $this->slugger = $slugger;
        $this->security= $security;
    }


    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDateAndUser'],
        ];
    }

    public function setDateAndUser (BeforeEntityPersistedEvent $event)
    {
    
        $entity = $event->getEntityInstance();

        if (($entity instanceof Project)){
            $now = new DateTime('now');
            $entity->setCreatedAt($now);
            $user = $this->security->getUser();
            $entity->setUser($user);
        }


        return;

    }
}