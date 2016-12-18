<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 16.12.11
 * Time: 10.30
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class MathService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function  _construct(EntityManager $em)
    {
        $this->em = $em;


    }

    public function addNumbers($a,$b)
    {
        $res = $a + $b;

        $user = User::get();



     $res =  $this->em->getRepository('AppBundle:Car')->find(3);

    }


}