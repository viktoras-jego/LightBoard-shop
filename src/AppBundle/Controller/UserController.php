<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * Class UserController
 *
 * @Route("/User")
 */
class UserController extends Controller
{

    /**
     * @Route("/User", name="User")
     * @var Request
     * @return Response
     */
    public function indexAction(Request $request)
    {

    $user = new User();
        $user->setUsername('useris')
            ->setPassword('password');

        $user ->getUsername();

//create our Form

        $form = $this->createFormBuilder($user)
        ->add('username',TextType::class)
            ->add('username',PasswordType::class)
            ->add('save',SubmitType::class,['label' => 'Create Car'])
            ->getForm()

            ;
        if ($form->isSubmitted() && $form->isValid()) {
            dump($user);

            $em = $this ->getDoctrine()->getManager();
            $em-> persist($user);
            $em->flush();

            return new Response();
        }

        //handling the form
        $form->handleRequest($request);


        return $this->render('user/index.html.twig',
            ['user' => $user,
            'form' => $form ->createView()])
                ;

    }
}