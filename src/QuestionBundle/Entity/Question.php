<?php

namespace QuestionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="QuestionBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=64, nullable=true)
     */
    private $tag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Suggestion", mappedBy="question", cascade={"persist"})
     */
    private $suggestions;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="questions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * @param ArrayCollection $suggestions
     *
     * @return $this
     */
    public function setSuggestions(ArrayCollection $suggestions)
    {
        $suggestions->forAll(function ($key, Suggestion $suggestion) {
            $suggestion->setQuestion($this);

            return true;
        });

        $this->suggestions = $suggestions;

        return $this;
    }

    /**
     * @param Suggestion $suggestion
     *
     * @return $this
     */
    public function addSuggestion(Suggestion $suggestion)
    {
        $this->suggestions->add($suggestion);

        $suggestion->setQuestion($this);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     *
     * @return $this
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * @param Answer $answer
     *
     * @return $this
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}

