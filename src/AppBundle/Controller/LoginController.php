<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function indexAction($name, $email)
    {
        $registration = new User();

        $form         = $this->createForm(new RegistrationType(), $registration, ['action' => $this->generateUrl('create'), 'method' => 'POST']);

        return $this->render('AppBundle:Default:register2.html.twig', ['form' => $form->createView(), 'email' => $email]);
    }
}
