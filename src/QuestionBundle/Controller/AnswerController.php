<?php

namespace QuestionBundle\Controller;

use QuestionBundle\Entity\Answer;
use QuestionBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionBundle:Default:index.html.twig');
    }

    public function displaySuggestionsAction($questionId) {
        /** @var Question $question */
        $question = $this->getDoctrine()
            ->getRepository('QuestionBundle:Question')
            ->find($questionId);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$questionId
            );
        }

        $suggestions = $question->getSuggestions();

        return $this->render('QuestionBundle:Answer:answer.html.twig', [
            'question' => $question,
            'suggestions' => $suggestions,
        ]);
    }

    public function answerQuestionAction(Request $request) {
        /** @var Question $question */
        $question = $this->getDoctrine()
            ->getRepository('QuestionBundle:Question')
            ->find($request->attributes->get('questionId'));

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$request->attributes->get('questionId')
            );
        }

        $suggestionId = (int) $request->request->all()['suggestion'];
        /** @var Suggestion $suggestion */
        $suggestion = $this->getDoctrine()
            ->getRepository('QuestionBundle:Suggestion')
            ->find($suggestionId);

        if (!$suggestion) {
            throw $this->createNotFoundException(
                'No suggestion found for id '.$suggestionId
            );
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $answer = new Answer();
        $answer->setCreatedAt(new \DateTime())
            ->setSuggestion($suggestion)
            ->setQuestion($question)
            ->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($answer);
        $em->flush();

        return $this->redirectToRoute('question_list');
    }
}
