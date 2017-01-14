<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 16.11.5
 * Time: 21.21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @package DoctBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="cash")
 *
 */
class Pinigai
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
     * @ORM\Column(type="string")
     */

    private $pinigai;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pinigai
     *
     * @param string $pinigai
     *
     * @return Pinigai
     */
    public function setPinigai($pinigai)
    {
        $this->pinigai = $pinigai;

        return $this;
    }

    /**
     * Get pinigai
     *
     * @return string
     */
    public function getPinigai()
    {
        return $this->pinigai;
    }
}
