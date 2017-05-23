<?php

namespace QuestionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Suggestion
 *
 * @ORM\Table(name="suggestion")
 * @ORM\Entity(repositoryClass="QuestionBundle\Repository\SuggestionRepository")
 */
class Suggestion
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
     * @var bool
     *
     * @ORM\Column(name="isCorrect", type="boolean", options={"default" : false})
     */
    private $isCorrect = false;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="suggestions", cascade={"all"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="suggestion")
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Suggestion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isCorrect
     *
     * @param boolean $isCorrect
     *
     * @return Suggestion
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @deprecated
     *
     * @return bool
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * Get isCorrect
     *
     * @return bool
     */
    public function isCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
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
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;
    }
}

