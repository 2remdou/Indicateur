<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Indicateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IndicateurRepository")
 */

class Indicateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleIndicateur", type="string", length=255)
     * @Assert\NotBlank(message="L'indicateur doit avoir un nom")
     */
    private $libelleIndicateur;

    /**
     * @var Doctrine\Common\Collections\Collection $detailIndicateurs
     *
     * @ORM\OneToMany(targetEntity="DetailIndicateur", mappedBy="indicateur")
     */
    private $detailIndicateurs;

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
     * Set libelleIndicateur
     *
     * @param string $libelleIndicateur
     * @return Indicateur
     */
    public function setLibelleIndicateur($libelleIndicateur)
    {
        $this->libelleIndicateur = $libelleIndicateur;

        return $this;
    }

    /**
     * Get libelleIndicateur
     *
     * @return string 
     */
    public function getLibelleIndicateur()
    {
        return $this->libelleIndicateur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailIndicateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add detailIndicateurs
     *
     * @param \AppBundle\Entity\DetailIndicateur $detailIndicateurs
     * @return Indicateur
     */
    public function addDetailIndicateur(\AppBundle\Entity\DetailIndicateur $detailIndicateurs)
    {
        $this->detailIndicateurs[] = $detailIndicateurs;

        return $this;
    }

    /**
     * Remove detailIndicateurs
     *
     * @param \AppBundle\Entity\DetailIndicateur $detailIndicateurs
     */
    public function removeDetailIndicateur(\AppBundle\Entity\DetailIndicateur $detailIndicateurs)
    {
        $this->detailIndicateurs->removeElement($detailIndicateurs);
    }

    /**
     * Get detailIndicateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailIndicateurs()
    {
        return $this->detailIndicateurs;
    }
}
