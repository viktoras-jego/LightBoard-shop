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
use AppBundle\Entity\Customer;
use AppBundle\Entity\Photos;
use AppBundle\Entity\Produktas;
use AppBundle\Entity\Shop;
use AppBundle\Entity\Skateboard;
use AppBundle\Form\CarType;
use AppBundle\Form\ShopType;
use AppBundle\Form\SkateboardType;
use AppBundle\Service\MathService;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DecimalType;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * Class ShopController
 *
 * @Route("/home")
 */
class ShopController extends Controller
{
    /**
     * @Route("/",name="car_index")
     */
    public function indexAction(Request $request){

        /*  $math = $this->get('app.math');
          $res = $math->addNumbers(2,3);
          dump($res);
          return new Response();*/


        $form = $this -> createFormBuilder()

            ->add('SHOP', SubmitType::class, [
                'label' => 'SHOP',
                'attr' => [
                    'class' => 'button_test'
                ]
            ])
            ->getForm()
        ;



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



        // dump($request-> query->get('comment'));

        $repo = $this->getDoctrine()->getRepository('AppBundle:Produktas');
        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Car');
        $cars = $repo2->findAll();
        $produktas = $repo->find(1);
        //$custom = $repo -> find(1);
        // $custom1 = $custom->getKaina();
        // dump($custom1);
        // return new Response();




        return $this->render('@FOSUser/Security/index.html.twig',[
            'cars' => $cars,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
            'form'=> $form ->createView(),
        ]);
    }

    /**
     * @Route("/shop",name="shop_page",defaults={"success" = null})
     * @param Request $request
     * @return Response
     */
    public function shop(Request $request,$success){

            $ats2 = null;

            if ($request->query->has('success')){
            $ats2 = 'success';
        }

            $repo = $this->getDoctrine()->getRepository('AppBundle:Skateboard')
                ->ByPrice($request);
            $pages= $repo['pages'];



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
                'product' => null,
                'last_username' => $lastUsername,
                'error' => $error,
                'success' => $ats2,
                'csrf_token' => $csrfToken,
                'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
                'skateboard'=>$repo['query'],
                'pagefirst'=>$repo['pagefirst'],
                'pages' => $pages,
                'orderValue' => $request->query->has('order') ? $request->query->get('order') : null,
                'moreThan' => $request->query->has('order2') ? $request->query->get('order2') : null,
                'lessThan' => $request->query->has('order3') ? $request->query->get('order3') : null,
                'category' => $request->query->has('order4') ? $request->query->get('order4') : null,
                'page' => $request->query->has('page') ? $request->query->get('page') : 1,
            ));

    }


    /**
     *
     * @Route("/add",name="add_product")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {


        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }
        $product = new Skateboard();


        $form = $this -> createFormBuilder($product)
            ->add('title',TextType::class,array(
                'attr' => array('style' => 'width: 200px;'),
                'label' => false,))

            ->add('category',ChoiceType::class, array(
                'label' => false,
                'attr' => array('style' => 'width: 200px;'),
                'choices' => array(
                    'Pennyboard' => 'Pennyboard',
                    'Skateboard' => 'Skateboard',
                    'Longboard' => 'Longboard',
                )
            ))
            ->add('price',MoneyType::class, array(
                'attr' => array('style' => 'width: 80px; height: 35px'),
                'label' => false,
                'currency' => false,
                'empty_data'  => '',
            ))
            ->add('description',TextareaType::class,array(
                'label' => false,
                'attr' => array('style' => 'width: 200px; height: 85px; max-width:200px; max-height: 85px;min-width:200px; min-height: 85px',
                    'row' => '4',
                    'col' => '4',
                    'maxlength' => "100"
                ),
                'required'    => false,
            ))
            ->add('randomString',HiddenType::class)
            ->add('img', FileType::class, [
                'label' => false,
                'mapped' => false,
                "attr" => array(
                    'style' => 'width: 100px',
                    "multiple" => false,
                    'id' =>'imgInp'
                ),
                'required'    => false,

            ])
            ->add('save',SubmitType::class,array(
                'label' => 'Save',
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



                $em = $this ->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

            return $this->redirectToRoute('shop_page');
        }
        $randomStr = $this ->get('Token_Generator')->generateRandomString();
        $form->get('randomString')->setData($randomStr);



        return $this->render('car/add.html.twig',[
                'id'=> $product->getId(),
                'randomStr'=> $randomStr,
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
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }


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




        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this ->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('shop_page');
        }
        return $this->render('car/edit.html.twig',[
            'product' => $skateboard,
            'forma'=> $form ->createView(),
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);

    }

    /**
     * @Route ("/trueedit/{skateboard}",name="trueedit_skate")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

    public function trueeditAction(Request $request, Skateboard $skateboard){

        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        $form = $this -> createFormBuilder($skateboard)
            ->add('title',TextType::class,array(
                'attr' => array('style' => 'width: 200px;'),
                'label' => false,))

            ->add('category',ChoiceType::class, array(
                'label' => false,
                'attr' => array('style' => 'width: 200px;'),
                'choices' => array(
                    'Pennyboard' => 'Pennyboard',
                    'Skateboard' => 'Skateboard',
                    'Longboard' => 'Longboard',
                )
            ))
            ->add('price',MoneyType::class, array(
                'attr' => array('style' => 'width: 80px; height: 35px'),
                'label' => false,
                'currency' => false,
            ))
            ->add('description',TextareaType::class,array(
                'label' => false,
                'attr' => array('style' => 'width: 200px; height: 85px; max-width:200px; max-height: 85px;min-width:200px; min-height: 85px',
                    'row' => '4',
                    'col' => '4',
                    'maxlength' => "100"
                ),
                'required'    => false,
            ))
            ->add('randomString',HiddenType::class)
            ->add('img', FileType::class, [
                'label' => false,
                'mapped' => false,
                "attr" => array(
                    'style' => 'width: 100px',
                    "multiple" => false,
                    'id' =>'imgInp'
                ),
                'required'    => false,

            ])
            ->add('save',SubmitType::class,array(
                'label' => 'Save',
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


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this ->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('shop_page');
        }
        $randomStr = $this ->get('Token_Generator')->generateRandomString();
        $form->get('randomString')->setData($randomStr);

        return $this->render('car/trueedit.html.twig',[
            'randomStr'=> $randomStr,
            'product' => $skateboard,
            'forma'=> $form ->createView(),
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);

    }

    /**
     * @Route ("/delete/{skateboard}",name="delete_skate")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

    public function deleteAction(Request $request, Skateboard $skateboard){

        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        $form = $this -> createFormBuilder($skateboard)
            ->add('save',SubmitType::class,array(
                'label' => 'Delete',
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


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this ->getDoctrine()->getManager();
            $url = $skateboard->getPhotos()->get(0);
            $em->remove($url);
            $em->remove($skateboard);
            $em->flush();
            return $this->redirectToRoute('shop_page');
        }

        return $this->render('car/delete2.html.twig',[
            'product' => $skateboard,
            'forma'=> $form ->createView(),
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);

    }

    /**
     * @Route ("/skate/{skateboard}",name="buy_skate")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

    public function buyAction(Request $request, Skateboard $skateboard){


        $product = new Customer();

        // Create our form


        $form = $this -> createFormBuilder($product)
            ->add('firstName',TextType::class,array(
                'label' => 'First name:',
            ))
            ->add('lastName',TextType::class,array(
                'label' => 'Last name:'
            ))
            ->add('address',TextType::class,array(
                'label' => 'Address:'
            ))
            ->add('city',TextType::class,array(
                'label' => 'City:'
            ))
            ->add('country',TextType::class,array(
                'label' => 'Country:'
            ))
            ->add('postcode',TextType::class,array(
                'label' => 'Postal code:'
            ))
            ->add('email',EmailType::class,array(
                'label' => 'Email:'
            ))
            ->add('quantity',ChoiceType::class,array(
                'label' => 'Quantity:',
                'choices'  => array(
            '1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9',
                ),
            ))

            ->add('title',HiddenType::class)
            ->add('category',HiddenType::class)
            ->add('price',HiddenType::class)
            ->add('description',HiddenType::class)
            ->add('photos',HiddenType::class)
            ->add('save',SubmitType::class,array(
                'label' => 'PROCEED',
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

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this ->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('shop_page', [
                'success' => 'success'
            ]);
        }
        $form->get('title')->setData($skateboard->getTitle());
        $form->get('price')->setData($skateboard->getPrice());
        $form->get('category')->setData($skateboard->getCategory());
        $form->get('description')->setData($skateboard->getDescription());
        $form->get('photos')->setData($skateboard->getPhotos()->get(0)->getUrl());




        return $this->render('car/buy.html.twig',[
            'product' => $skateboard,
            'forma'=> $form ->createView(),
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);

    }
    /**
     * @Route ("/order",name="order_skate")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

    public function orderAction(Request $request){

        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }
        if ($request->query->has('status')){
                $ids = $request->query->all();
                //Here unset all values to get good submit result
                unset($ids["status"]);
                unset($ids["orderTime"]);
                unset($ids["orderTime2"]);
                unset($ids["TextSearch"]);
                unset($ids["page"]);
                unset($ids["page2"]);
                unset($ids["TextSearch2"]);



                foreach ($ids as $key => $value){

                    $repox = $this->getDoctrine()->getRepository('AppBundle:Customer')->find($key);
                    $processDate = $repox -> getProcessdate();
                    if ($processDate == null) {
                        $repox->setDelivery($value);
                        $repox->setProcessdate(new \DateTime());
                        $em = $this->getDoctrine()->getManager();
                        $em->flush($repox);
                    }
                }
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:Customer')
            ->DoneOrder($request);
        $doneresult= $repo['query'];

        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Customer')
            ->NotDoneOrder($request);
        $doneresult2= $repo2['query2'];

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


      // if ($form->isSubmitted() && $form->isValid()) {


      //     $em = $this->getDoctrine()->getManager();
      //     $em->flush();
      //     return $this->redirectToRoute('order_skate');
      // }

        return $this->render('car/order.html.twig',[
            'pagefirst'=>$repo['pagefirst'],
            'pages' => $repo['pages'],
            'currentpage2' => $repo2['currentpage2'],
            'currentpage' => $repo['currentpage'],
            'pagefirst2'=>$repo2['pagefirst2'],
            'pages2' => $repo2['pages2'],
            'page' => $request->query->has('page') ? $request->query->get('page') : 1,
            'page2' => $request->query->has('page2') ? $request->query->get('page2') : 1,
            'TextSearch' => $request->query->has('TextSearch') ? $request->query->get('TextSearch') : null,
            'TextSearch2' => $request->query->has('TextSearch2') ? $request->query->get('TextSearch2') : null,
            'orderTime' => $request->query->has('orderTime') ? $request->query->get('orderTime') : null,
            'orderTime2' => $request->query->has('orderTime2') ? $request->query->get('orderTime2') : null,
            'skateboard'=>$doneresult,
            'skateboard2'=>$doneresult2,
            'edit' =>true,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);

    }

    /**
     * @Route ("/crop", name="crop_image")
     * @param Request $request
     * @return Response
     */
    public function cropAction(Request $request){


        $content = json_decode($request->getContent(), true);

        $image = $content['image'];
        $randomStr2 = $content['randomStr'];

if($image != null){

                $client_id="d5bfa397cfd42db";
                $timeout = 30;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $image);
                $out = curl_exec($curl);
                curl_close ($curl);
                $pms = json_decode($out,true);
                $url=$pms['data']['link'];

                $em = $this->getDoctrine()->getManager();
                $prod = $em->getRepository('AppBundle:Skateboard')->findOneBy([
                    'randomString'=> $randomStr2
                ]);
                $photo = new Photos();
                $photo->setUrl($url);
                $photo->setSkateboard($prod);
                $em->persist($photo);
                $em->flush();

}
        return $this->redirectToRoute('shop_page');
    }
    /**
     * @Route ("/crop2", name="crop2_image")
     * @param Request $request
     * @return Response
     */
    public function crop2Action(Request $request){
        $content = json_decode($request->getContent(), true);
        $image = $content['image'];
        $randomStr2 = $content['randomStr'];


        if($image != null){

            $em = $this->getDoctrine()->getManager();
            $prod = $em->getRepository('AppBundle:Skateboard')->findOneBy([
                'randomString'=> $randomStr2
            ]);
            $client_id="d5bfa397cfd42db";
            $timeout = 30;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $image);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out,true);
            $url=$pms['data']['link'];

            $photo = $prod->getPhotos()[0];

            $photo->setUrl($url);
            $photo->setSkateboard($prod);

            $em->flush();

        }


        return $this->redirectToRoute('shop_page');

    }


    /**
     * @Route("/login",name="login_skate")
     */
    public function loginAction(Request $request){

        $session = $request->getSession();
        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
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
        // dump($request-> query->get('comment'));
        $repo = $this->getDoctrine()->getRepository('AppBundle:Produktas');
        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Car');
        $cars = $repo2->findAll();
        $produktas = $repo->find(1);

        return $this->render('@FOSUser/Security/login.html.twig',[
            'cars' => $cars,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ]);
    }
    /**
     * @param Request $request
     * @Route("/register",name="register_skate")
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);


        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);


                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $response = $this->redirectToRoute('confirmed_action');
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
            'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
        ));
    }

    /**
     * Tell the user to check his email provider.
     */
    public function checkEmailAction()
    {
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');

        if (empty($email)) {
            return new RedirectResponse($this->get('router')->generate('fos_user_registration_register'));
        }

        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->render('FOSUserBundle:Registration:check_email.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * @Route("/confirmed",name="confirmed_action")
     */
    public function confirmedAction()
    {
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * @return mixed
     */
    private function getTargetUrlFromSession()
    {
        $role = [];
        if($this->getUser()){
            $role = $this->getUser()->getRoles();
        }

        if(!in_array('ROLE_USER', $role)){
            return $this->redirectToRoute('car_index');
        }

        $key = sprintf('_security.%s.target_path', $this->get('security.token_storage')->getToken()->getProviderKey());

        if ($this->get('session')->has($key)) {
            return $this->get('session')->get($key);
        }
    }

    /**
     *
     * @Route("/contact",name="constact_skate")
     * @param Request $request
     * @return Response
     */
    public function contacAction(Request $request)
    {



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





        return $this->render('car/contact.html.twig',[
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
            ]
        );
    }
}