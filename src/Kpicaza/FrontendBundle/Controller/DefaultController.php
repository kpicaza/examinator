<?php

namespace Kpicaza\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KpicazaFrontendBundle:Default:index.html.twig');
    }
}
