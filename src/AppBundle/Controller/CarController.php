<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Cash;
use AppBundle\Entity\Produktas;
use AppBundle\Form\CarType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DecimalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 *
 * Class CarController
 *
 * @Route("/car")
 */
class CarController extends Controller

{






    /**
     * @Route("/",name="car_index")
     */
    public function indexAction(Request $request){

       // dump($request-> query->get('comment'));

        $repo = $this->getDoctrine()->getRepository('AppBundle:Produktas');
        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Car');
         $cars = $repo2->findAll();
        $produktas = $repo->find(1);
        //$custom = $repo -> find(1);
       // $custom1 = $custom->getKaina();
      // dump($custom1);
      // return new Response();

       return $this->render('car/index.html.twig',[
           'cars' => $cars,
            'kaina' => $produktas->getKaina(),

        ]);
    }


//test


    /**
     * @Route("/ad",name="add_produktas")
     * @param Request $request
     * @return Response
     */

    public function addAction2(Request $request)
    {

        $produktas = new Produktas();
        $em = $this ->getDoctrine()->getManager();


        // Create our form
        $form = $this -> createFormBuilder($produktas)
            ->add('kaina',NumberType::class)
            ->add('save',SubmitType::class,['label' => 'Add money'])
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // Istraukiu is duombazes Objekta
           $baze = $em->getRepository('AppBundle:Produktas')->find(1);

            $baze->setKaina( $baze->getKaina() + $produktas->getKaina() );

            $em->flush();


            return $this->redirectToRoute('car_index');
        }



        return $this->render('car/add.html.twig',[
                'produktas' => $produktas,
                'forma'=> $form ->createView(),
                'edit' =>false,
            ]
        );}






    /**
     * @Route("/add",name="add_car")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $car = new Car();

        // Create our form
        $form = $this -> createFormBuilder($car)
            ->add('comment',TextType::class)
            ->add('Price',NumberType::class)
            ->add('save',SubmitType::class,['label' => 'Create Car'])
            ->getForm()
            ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this ->getDoctrine()->getManager();
            $em-> persist($car);
            $em->flush();


            return $this->redirectToRoute('car_index');
        }



        return $this->render('car/add.html.twig',[
                'car' => $car,
                'forma'=> $form ->createView(),
                'edit' =>false,
            ]
        );}

    /**
     * @Route ("/edit/{car}",name="edit_car")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

        public function editAction(Request $request, Car $car){


                $form = $this->createForm(CarType::class, $car)

            ;
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                $em = $this ->getDoctrine()->getManager();

                $em->flush();


                return $this->redirectToRoute('car_index');
            }

            return $this->render('car/add.html.twig',[
                    'car' => $car,
                    'forma'=> $form ->createView(),
                'edit' =>true,
            ]);



    }

    /**
     * @Route ("-delete/{car}",name="delete_car")
     */

    public function deleteAction(Request $request, Car $car){

        $form = $this -> createFormBuilder($car)
            ->add('save',SubmitType::class,['label' => 'Buy'])
            ->getForm();

        $form2 = $this -> createFormBuilder($car)
            ->add('save2',SubmitType::class,['label' => 'Back'])
            ->getForm();


        $form->handleRequest($request);
        $form2->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {


            $em = $this ->getDoctrine()->getManager();
            $baze = $em->getRepository('AppBundle:Produktas')->find(1);
           $price =$car->getPrice();



          if($price < $baze->getKaina()) {
            $baze->setKaina($baze->getKaina() - $price);
               $em->remove($car);
         }
         else{

             $this->addFlash(
                 'notice',
                 'Not enough money'
             );
         }

            $em->flush();
            return $this->redirectToRoute('car_index');
        }



        if ($form2->isSubmitted() && $form2->isValid()) {


            return $this->redirectToRoute('car_index');
        }


        return $this->render('car/delete.html.twig',[
                'car' => $car,
                'forma'=> $form ->createView(),
                'forma2'=> $form2 ->createView(),
            ]
        );
    }
}
