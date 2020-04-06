<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Request;


class EntityCreatedSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args, Request $request)
    {
        $object = $args->getObject();

        if ($object instanceof Article) {
            $object->setCreated(new DateTime()); // Date de création auto
            
            // A sa création, un article devra être placé par défaut en statut "brouillon" 
            if ($request->isMethod('POST')) {
            $object->setStatus(1); // Article en Brouillon
            }

            // lorsque le statut d'un article passera en "publié" (valeur 2) on met la date du jour dans Published
            if ($object->getStatus()== 2){
                $object->setPublished(new DateTime());
            }
        }
        else if($object instanceof Category) {
            $object->setCreated(new DateTime());
        }
    }

}