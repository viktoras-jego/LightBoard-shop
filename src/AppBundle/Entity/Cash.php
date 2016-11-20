<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 16.11.5
 * Time: 21.13
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @package DoctBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="pinigai")
 *
 */

class Cash
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     *
     * @ORM\GeneratedValue()\Column( type="string")
     */

    private $money;

}