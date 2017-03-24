<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * themes
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\themeRepository")
 */
class theme
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_discussions", type="integer")
     */
    private $nbDiscussions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_discussion", type="datetime")
     */
    private $lastDiscussion;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return theme
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nbDiscussions
     *
     * @param integer $nbDiscussions
     *
     * @return theme
     */
    public function setNbDiscussions($nbDiscussions)
    {
        $this->nbDiscussions = $nbDiscussions;

        return $this;
    }

    /**
     * Get nbDiscussions
     * @return int
     */
    public function getNbDiscussions()
    {
        return $this->nbDiscussions;
    }

    /**
     * Set lastDiscussion
     *
     * @param \DateTime $lastDiscussion
     *
     * @return theme
     */
    public function setLastDiscussion($lastDiscussion)
    {
        $this->lastDiscussion = $lastDiscussion;

        return $this;
    }

    /**
     * Get lastDiscussion
     *
     * @return \DateTime
     */
    public function getLastDiscussion()
    {
        return $this->lastDiscussion;
    }

}

