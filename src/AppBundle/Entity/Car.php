<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var = string
     *
     * @ORM\Column(name="comment", type="string",length=255,nullable=true)
     */

    private $comment;

//-------------------------------------------------------------
    /**
     * @var int
     *
     * @ORM\Column(name="Price", type="integer",length=255)
     */

    private $Price;
//-------------------------------------------------------------

    /**
     * @var
     * 
     * /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CarModel")
     */


    private $model;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\CarModel $model
     *
     * @return Car
     */
    public function setModel(\AppBundle\Entity\CarModel $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\CarModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Car
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set Price
     *
     * @param int $Price
     *
     * @return Car
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;

        return $this;
    }


    /**
     * Get Price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->Price;
    }
}
