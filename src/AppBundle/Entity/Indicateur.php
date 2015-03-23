<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Indicateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IndicateurRepository")
 * @ExclusionPolicy("all")
 * @UniqueEntity("libelleIndicateur",message="Ce libelle existe deja",groups={"common"})
 */

class Indicateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     * @SerializedName("id")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleIndicateur", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="L'indicateur doit avoir un nom", groups={"registration"})
     * @ORM\Column(name="libelleIndicateur", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="L'indicateur doit avoir un nom")
     * @Expose()
     * @SerializedName("libelleIndicateur")
     */

    private $libelleIndicateur;

    /**
     * @var Doctrine\Common\Collections\Collection $detailIndicateurs
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DetailIndicateur", mappedBy="indicateur")
     *
     */
    private $detailIndicateurs;

    /**
     * @var TypeIndicateur $typeIndicateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeIndicateur", inversedBy="indicateur",cascade={"persist","remove"})
     * @Expose()
     * @ORM\JoinColumn(nullable=false)
     * @SerializedName("typeIndicateur")
     */
    private  $typeIndicateur;
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

    /**
     * Set typeIndicateur
     *
     * @param \AppBundle\Entity\TypeIndicateur $typeIndicateur
     * @return Indicateur
     */
    public function setTypeIndicateur(\AppBundle\Entity\TypeIndicateur $typeIndicateur = null)
    {
        $this->typeIndicateur = $typeIndicateur;

        return $this;
    }

    /**
     * Get typeIndicateur
     *
     * @return \AppBundle\Entity\TypeIndicateur 
     */
    public function getTypeIndicateur()
    {
        return $this->typeIndicateur;
    }

    public function update(Indicateur $newIndicateur){
        $this->setLibelleIndicateur($newIndicateur->getLibelleIndicateur());
        $this->setTypeIndicateur($newIndicateur->setTypeIndicateur());
        $this->setTypeIndicateur($newIndicateur->getTypeIndicateur());
    }
}
