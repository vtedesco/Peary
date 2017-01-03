<?php
 
namespace Vted\PearyBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\EntityManager;

use Vted\PearyBundle\Entity\ErrorLog;

class ExceptionListener
{
    protected $container;
    protected $em;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
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
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $log->setUsername($this->container->get('security.context')->getUser()->getUsername());
                $log->setUserid($this->container->get('security.context')->getUser()->getId());
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

            if( in_array($log->getCode(), array('0','404','500'))){
                $this->em->persist($log);
                $this->em->flush(); 
            }

        }

        // Prevent this par of code to crash the entire error handling
        catch(\Exception $e) {}
    }
}