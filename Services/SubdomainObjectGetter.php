<?php

namespace Netgusto\DynamicSubdomainBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class SubdomainObjectGetter {

    public function __construct(EntityManager $entityManager, Request $request) {
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    public function getSubdomainObject() {
        return $this->entityManager->getRepository($this->request->attributes->get('subdomainobject_class'))->findOneById(
            $this->request->attributes->get('subdomainobject_id')
        );
    }
}