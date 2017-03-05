<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 17.2.5
 * Time: 12.12
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Photos
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="information")
     *
     * @var = string
     *
     * @ORM\Column(name="url", type="string",length=255,nullable=false)
     */

    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skateboard", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skateboard;





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
     * Set url
     *
     * @param string $url
     *
     * @return Photos
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set skateboard
     *
     * @param \AppBundle\Entity\Skateboard $skateboard
     *
     * @return Photos
     */
    public function setSkateboard(\AppBundle\Entity\Skateboard $skateboard)
    {
        $this->skateboard = $skateboard;

        return $this;
    }

    /**
     * Get skateboard
     *
     * @return \AppBundle\Entity\Skateboard
     */
    public function getSkateboard()
    {
        return $this->skateboard;
    }
}
