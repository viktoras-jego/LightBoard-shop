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
 * @ORM\Table(name="pin")
 *
 */

class Money
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
     * @ORM\Column( type="string")
     */

    private $money;

     /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Money")
      * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */

    private $address;


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
     * Set money
     *
     * @param string $money
     *
     * @return Money
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return string
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Money $address
     *
     * @return Money
     */
    public function setAddress(\AppBundle\Entity\Money $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Money
     */
    public function getAddress()
    {
        return $this->address;
    }
}
