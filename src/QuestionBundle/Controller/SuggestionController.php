<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 14/05/2017
 * Time: 17:59
 */

namespace QuestionBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SuggestionController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionBundle:Default:index.html.twig');
    }

    public function viewAction($question_id, $id) {

    }

    public function createAction($question_id) {

    }
}