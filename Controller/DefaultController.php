<?php

namespace Vted\PearyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    
        return $this->render('VtedPearyBundle:Default:index.html.twig', array('name' => 'a'));
    }
}
