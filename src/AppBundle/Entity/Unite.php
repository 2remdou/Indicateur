<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Unite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UniteRepository")
 * @ExclusionPolicy("all")
 * @UniqueEntity("codeUnite",message="Ce code est deja affecté à une autre unite",groups={"create"})
 * @UniqueEntity("libelleUnite",message="Ce libelle est deja affecté à une autre unite",groups={"create"})
 */
class Unite
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
     * @ORM\Column(name="codeUnite", type="string", length=255, unique=true)
     * @Expose()
     * @SerializedName("codeUnite")
     * @Assert\NotBlank(message="Veuillez indiquer un code à l'unite",groups={"common"})
     */
    private $codeUnite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleUnite", type="string", length=255, unique=true)
     * @Expose()
     * @SerializedName("libelleUnite")
     * @Assert\NotBlank(message="Veuillez indiquer un libelle à l'unite",groups={"common"})
     */
    private $libelleUnite;

    /**
     * @var Doctrine\Common\Collections\Collection $detailIndicateurs
     *
     * @ORM\OneToMany(targetEntity="DetailIndicateur", mappedBy="unite")
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
     * Set codeUnite
     *
     * @param string $codeUnite
     * @return Unite
     */
    public function setCodeUnite($codeUnite)
    {
        $this->codeUnite = $codeUnite;

        return $this;
    }

    /**
     * Get codeUnite
     *
     * @return string 
     */
    public function getCodeUnite()
    {
        return $this->codeUnite;
    }

    /**
     * Set libelleUnite
     *
     * @param string $libelleUnite
     * @return Unite
     */
    public function setLibelleUnite($libelleUnite)
    {
        $this->libelleUnite = $libelleUnite;

        return $this;
    }

    /**
     * Get libelleUnite
     *
     * @return string 
     */
    public function getLibelleUnite()
    {
        return $this->libelleUnite;
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
     * @return Unite
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

    public function update(Unite $newUnite){
        $this->setCodeUnite($newUnite->getCodeUnite());
        $this->setLibelleUnite($newUnite->getLibelleUnite());
    }
}
