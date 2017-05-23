<?php
/**
 * Created by PhpStorm.
 * User: jbaron
 * Date: 13/05/2017
 * Time: 19:10
 */

namespace QuestionBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionBundle:Default:home.html.twig');
    }
}