<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use QuestionBundle\Entity\Answer;

/**
 * Created by PhpStorm.
 * User: jbaron
 * Date: 13/05/2017
 * Time: 17:47
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="QuestionBundle\Entity\Answer", mappedBy="user")
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="QuestionBundle\Entity\Question", mappedBy="user")
     */
    private $questions;

    public function __construct()
    {
        parent::__construct();
        $this->answers = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answers;
    }

    /**
     * @param Answer $answer
     */
    public function setAnswer($answer)
    {
        $this->answers = $answer;
    }

    /**
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param mixed $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }


    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;
    }

}