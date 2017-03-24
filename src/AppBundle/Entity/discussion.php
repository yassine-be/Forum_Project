<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * discussion
 *
 * @ORM\Table(name="discussion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\discussionRepository")
 */
class discussion
{


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\theme")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

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
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_time", type="datetime")
     */
    private $dateTime;

    /**
     * @var int
     *
     * @ORM\Column(name="theme_id", type="integer")
     */
    private $themeId;


    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }


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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return discussion
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     *
     * @return discussion
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set themeId
     *
     * @param integer $themeId
     *
     * @return discussion
     */
    public function setThemeId($themeId)
    {
        $this->themeId = $themeId;

        return $this;
    }

    /**
     * Get themeId
     *
     * @return integer
     */
    public function getThemeId()
    {
        return $this->themeId;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return discussion
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }





}




