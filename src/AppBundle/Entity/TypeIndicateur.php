<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TypeIndicateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TypeIndicateurRepository")
 * @ExclusionPolicy("all")
 * @UniqueEntity("libelleTypeIndicateur",message="Ce libelle existe deja",groups={"common"})
 */
class TypeIndicateur
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
     * @ORM\Column(name="libelleTypeIndicateur", type="string", length=255, unique=true)
     * @Expose()
     * @Assert\NotBlank(message="Fournissez le libelle type indicateur")
     * @SerializedName("libelleTypeIndicateur")
     */
    private $libelleTypeIndicateur;

    /**
     * @var Doctrine\Common\Collections\Collection $indicateurs
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DetailIndicateur", mappedBy="typeIndicateur")
     */
    private $indicateurs;

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
     * Set libelleTypeIndicateur
     *
     * @param string $libelleTypeIndicateur
     * @return TypeIndicateur
     */
    public function setLibelleTypeIndicateur($libelleTypeIndicateur)
    {
        $this->libelleTypeIndicateur = $libelleTypeIndicateur;

        return $this;
    }

    /**
     * Get libelleTypeIndicateur
     *
     * @return string 
     */
    public function getLibelleTypeIndicateur()
    {
        return $this->libelleTypeIndicateur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add indicateurs
     *
     * @param \AppBundle\Entity\DetailIndicateur $indicateurs
     * @return TypeIndicateur
     */
    public function addIndicateur(\AppBundle\Entity\DetailIndicateur $indicateurs)
    {
        $this->indicateurs[] = $indicateurs;

        return $this;
    }

    /**
     * Remove indicateurs
     *
     * @param \AppBundle\Entity\DetailIndicateur $indicateurs
     */
    public function removeIndicateur(\AppBundle\Entity\DetailIndicateur $indicateurs)
    {
        $this->indicateurs->removeElement($indicateurs);
    }

    /**
     * Get indicateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicateurs()
    {
        return $this->indicateurs;
    }

    public function update(TypeIndicateur $newTypeIndicateur){
        $this->setLibelleTypeIndicateur($newTypeIndicateur->getLibelleTypeIndicateur());
    }
}
