<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Hote
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HoteRepository")
 * @ExclusionPolicy("all")
 */
class Hote
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     * @SerializedName("id")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseHote", type="string", length=255)
     * @Expose()
     * @SerializedName("adresseHote")
     * @Assert\Ip(message="Veuillez fournir une adresse ip valide")
     */
    private $adresseHote;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleHote", type="string", length=255)
     * @Expose()
     * @SerializedName("libelleHote")
     * @Assert\NotBlank(message="Veuillez fournir le libelle")
     */
    private $libelleHote;


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
     * Set libelleHote
     *
     * @param string $libelleHote
     * @return Hote
     */
    public function setLibelleHote($libelleHote)
    {
        $this->libelleHote = $libelleHote;

        return $this;
    }

    /**
     * Get libelleHote
     *
     * @return string 
     */
    public function getLibelleHote()
    {
        return $this->libelleHote;
    }

    public function update(Hote $newHote){
        $this->setAdresseHote($newHote->getAdresseHote());
        $this->setLibelleHote($newHote->getLibelleHote());
    }

    /**
     * Set adresseHote
     *
     * @param string $adresseHote
     * @return Hote
     */
    public function setAdresseHote($adresseHote)
    {
        $this->adresseHote = $adresseHote;

        return $this;
    }

    /**
     * Get adresseHote
     *
     * @return string 
     */
    public function getAdresseHote()
    {
        return $this->adresseHote;
    }
}
