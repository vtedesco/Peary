<?php

namespace Vted\PearyBundle\Listener;

use Symfony\Component\HttpKernel\Kernel;

class EmailSendListener {
    
    protected $env;
    public function __construct(Kernel $kernel) {
        $this->env = $kernel->getEnvironment();
    }

    public function mailerSend( $event) {
        // Récupération du mail
        $message = $event->getMessage();
        // Si hors prod, ajout de l'environnement dans le titre
        if(!is_null($message) && $this->env != 'prod'){
            $message->setSubject('[ ' . strtoupper($this->kernel->getEnvironment()) . ' ] ' . $message->getSubject());
        }
    }
}