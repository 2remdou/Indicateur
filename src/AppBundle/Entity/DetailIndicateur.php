<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;

/**
 * DetailIndicateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DetailIndicateurRepository")
 * @ExclusionPolicy("all")
 */
class DetailIndicateur
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDetail", type="datetime",nullable=false)
     * @Expose()
     * @SerializedName("dateDetail")
     * @Assert\NotBlank(message="Veuillez fournir une date")
     */
    private $dateDetail;


    /**
     * @var
     * @ORM\Column(name="valeur",type="decimal",nullable=false)
     * @Assert\Type(type="numeric",message="la valeur doit etre un numerique")
     * @Expose()
     * @SerializedName("valeur")
     * @Assert\NotBlank(message="Veuillez fournir une valeur")
     */
    private $valeur;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Indicateur", inversedBy="detailIndicateurs")
     * @Expose()
     * @SerializedName("indicateur")
     */
    private $indicateur;

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
     * Set indicateur
     *
     * @param \AppBundle\Entity\Indicateur $indicateur
     * @return DetailIndicateur
     */
    public function setIndicateur(\AppBundle\Entity\Indicateur $indicateur = null)
    {
        $this->indicateur = $indicateur;

        return $this;
    }

    /**
     * Get indicateur
     *
     * @return \AppBundle\Entity\Indicateur 
     */
    public function getIndicateur()
    {
        return $this->indicateur;
    }


    public function update(DetailIndicateur $newDetail)
    {
        $this->setDate($newDetail->getDate());
        $this->setValeur($newDetail->getValeur());
        if($newDetail->getIndicateur() !== $this->getIndicateur()){
            $this->setIndicateur($newDetail->getIndicateur());
        }
    }

    /**
     * Set valeur
     *
     * @param string $valeur
     * @return DetailIndicateur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set dateDetail
     *
     * @param \DateTime $dateDetail
     * @return DetailIndicateur
     */
    public function setDateDetail($dateDetail)
    {
        $this->dateDetail =new \DateTime($dateDetail);

        return $this;
    }

    /**
     * Get dateDetail
     *
     * @return \DateTime 
     */
    public function getDateDetail()
    {
        return $this->dateDetail;
    }

}
