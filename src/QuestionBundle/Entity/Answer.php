<?php

namespace QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="QuestionBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers", cascade={"remove"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="Suggestion", inversedBy="answers", cascade={"remove"})
     * @ORM\JoinColumn(name="suggestion_id", referencedColumnName="id")
     */
    private $suggestion;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="answers", cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Answer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Answer
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Answer $question
     *
     * return Answer
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Answer
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * @param Answer $suggestion
     *
     * return Answer
     */
    public function setSuggestion($suggestion)
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    /**
     * @return Answer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Answer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

