<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 16.11.5
 * Time: 22.44
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="produktas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */

class Produktas
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
     * @var = int
     *
     * @ORM\Column(name="kaina", type="integer",length=255,nullable=true)
     */

    private $kaina;

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
     * Set kaina
     *
     * @param int $kaina
     *
     * @return Produktas
     */
    public function setKaina($kaina)
    {
        $this->kaina = $kaina;

        return $this;
    }

    /**
     * Get kaina
     *
     * @return integer
     */
    public function getKaina()
    {
        return $this->kaina;
    }
}
