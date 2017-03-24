<?php

namespace Vted\PearyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailController extends Controller
{
    public function indexAction()
    {
        return $this->render('VtedPearyBundle:Email:index.html.twig');
    }
}
