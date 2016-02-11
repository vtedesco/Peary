<?php
 
namespace Vted\PearyBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;

use Vted\PearyBundle\Entity\ErrorLog;

class ExceptionListener
{
    protected $securityContext;
    protected $em;

    public function __construct(SecurityContext $securityContext, EntityManager $entityManager) {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }

    /**
     * Log de l'erreur dans MongoDB
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // don't do anything if it's not the master request
        if(!$event->isMasterRequest()) {
            return;
        }

        // Create logs
        try {
            $log = new ErrorLog();
            
            $exception = $event->getException();
            $request = $event->getRequest();

            // Current User
            if($this->securityContext->getToken() && $this->securityContext->isGranted('ROLE_USER')) {
                $log->setUsername($this->securityContext->getToken()->getUser()->getUsername());
                $log->setUserid($this->securityContext->getToken()->getUser()->getId());
            } else {
                $log->setUsername(null);
            }

            // Get error code
            if(method_exists($exception, 'getStatusCode')) {
                $log->setCode($exception->getStatusCode());
            } else {
                $log->setCode($exception->getCode());
            }

            $log->setMessage($exception->getMessage());
            $log->setUrl($request->getUri());
            $log->setIp($request->getClientIp());
            $log->setReferer($request->headers->get('referer'));

            if( in_array($log->getCode(), array('404','500'))){
                $this->em->persist($log);
                $this->em->flush(); 
            }

        }

        // Prevent this par of code to crash the entire error handling
        catch(\Exception $e) {}
    }
}