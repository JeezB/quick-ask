<?php

namespace QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AnswerController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionBundle:Default:index.html.twig');
    }

    public function createAction($question_id) {

    }
}
