<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 17.1.13
 * Time: 17.34
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Car;
use AppBundle\Entity\Cash;
use AppBundle\Entity\Produktas;
use AppBundle\Entity\Shop;
use AppBundle\Entity\Skateboard;
use AppBundle\Form\CarType;
use AppBundle\Form\ShopType;
use AppBundle\Form\SkateboardType;
use AppBundle\Service\MathService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DecimalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class ShopController extends Controller
{
    /**
     * @Route("/shop",name="shop_page")
     * @param Request $request
     * @return Response
     */
    public function shop(Request $request){
        {
            $product = new Shop();
            $form = $this->createForm(ShopType::class, $product);
            $form->handleRequest($request);

            $repo = $this->getDoctrine()->getRepository('AppBundle:Skateboard');
            $skateboard = $repo->findAll();





            /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
            $session = $request->getSession();

            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;

            // get the error if any (works with forward and redirect -- see below)
            if ($request->attributes->has($authErrorKey)) {
                $error = $request->attributes->get($authErrorKey);
            } elseif (null !== $session && $session->has($authErrorKey)) {
                $error = $session->get($authErrorKey);
                $session->remove($authErrorKey);
            } else {
                $error = null;
            }

            if (!$error instanceof AuthenticationException) {
                $error = null; // The value does not come from the security component.
            }

            // last username entered by the user
            $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

            $csrfToken = $this->has('security.csrf.token_manager')
                ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
                : null;

            $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);





            return $this->render('@FOSUser/Security/shop.html.twig', array(
                'form' => $form->createView(),
                'product' => null,
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
                'skateboard'=>$skateboard,
            ));
        }
    }


    /**
     * @Route("/add",name="add_product")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $product = new Skateboard();

        // Create our form
        $form = $this -> createFormBuilder($product)
            ->add('title',TextType::class)

            ->add('category',ChoiceType::class, array(
                'label' => 'Category',
                'choices' => array(
                    'Pennyboard' => 'Pennyboard',
                    'Skateboard' => 'Skateboard',
                    'Longboard' => 'Longboard',
                )
            ))
            ->add('price',MoneyType::class, array(
                'label' => ' ',
            ))
            ->add('description',TextareaType::class,array(
                'label' => 'Description',
                'attr' => array('style' => 'width: 100px;',
                'style' => 'height: 75px'
                ),
                'required'    => false,
            ))
            ->add('img', FileType::class, [
                'label' => 'img',
                'mapped' => false
            ])
            ->add('save',SubmitType::class,array(
                'label' => 'Create',
                'attr' => array('style' => 'width: 100px')
            ))
            ->getForm()
        ;
        $form->handleRequest($request);

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        if ($form->isSubmitted() && $form->isValid()) {

            $filename = $form->get('img')->getData()->getPathname();
            $client_id="d5bfa397cfd42db";
            $handle = fopen($filename, "r");
            $data = fread($handle, filesize($filename));
            $pvars   = array('image' => base64_encode($data));
            $timeout = 30;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out,true);
            $url=$pms['data']['link'];

            if($pms && isset($pms['status']) && $pms['status'] == 200){
                $em = $this ->getDoctrine()->getManager();

                $em->flush();
                return $this->redirectToRoute('shop_page');
            }else{
                echo "<h2>There's a Problem</h2>";
                echo $pms['data']['error'];
            }



        }



        return $this->render('car/add.html.twig',[
                'product' => $product,
                'forma'=> $form ->createView(),
                'edit' =>false,
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
            ]
        );
    }

    /**
     * @Route ("/product/{skateboard}",name="edit_skate")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

    public function editAction(Request $request, Skateboard $skateboard){

        $form = $this->createForm(SkateboardType::class, $skateboard);
        $form->handleRequest($request);

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);


        if ($form->isSubmitted() && $form->isValid()) {



            if($url!=""){
                $em = $this ->getDoctrine()->getManager();

                $em->flush();

                return $this->redirectToRoute('shop_page');
            }else{
                echo "<h2>There's a Problem</h2>";
                echo $pms['data']['error'];
            }


        }

        return $this->render('shop.html.twig',[
            'product' => $skateboard,
            'forma'=> $form ->createView(),
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);



    }

}