<?php

namespace Netgusto\DynamicSubdomainBundle\Services;

use Symfony\Component\HttpKernel\HttpKernel,
    Symfony\Component\HttpKernel\HttpKernelInterface,
    Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Doctrine\ORM\EntityManager;

use Netgusto\DynamicSubdomainBundle\Exception\DomainNotFoundException;

class ClientInjecterRequestListener {

    private $entityManager;
    private $base_host;
    private $parameter_name;
    private $entity;
    private $property;

    public function __construct(EntityManager $entityManager, $base_host, $parameter_name, $entity, $property) {
        $this->entityManager = $entityManager;
        $this->base_host = $base_host;
        $this->parameter_name = $parameter_name;
        $this->entity = $entity;
        $this->property = $property;
    }

    public function onKernelRequest(GetResponseEvent $event) {

        #if(HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
        #    # ne rien faire si ce n'est pas la requête principale
        #    return;
        #}

        $request = $event->getRequest();
        # On identifie l'objet sous-domaine courant

        $host = $request->getHost();
        $subdomain = substr($host, 0, ((strlen($this->base_host) + 1) * -1));
        $subdomainobject = $this->entityManager->getRepository($this->entity)->findOneBy(array(
            $this->property => $subdomain
        ));

        if(!$subdomainobject) {
            throw new DomainNotFoundException(sprintf(
                'No subdomain mapped for host "%s", subdomain "%s"',
                $host,
                $subdomain
            ));
        }

        # On injecte l'objet sous-domaine identifié dans chaque requête faite à l'application
        $event->getRequest()->attributes->set(
            $this->parameter_name,
            $subdomainobject
        );
    }
}
