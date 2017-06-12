<?php

namespace QuestionBundle\Controller;

use QuestionBundle\Entity\Question;
use QuestionBundle\Entity\Suggestion;
use QuestionBundle\Form\Type\SuggestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionBundle:Default:index.html.twig');
    }

    /**
     * @param $id
     * @return Response
     */
    public function viewAction($id)
    {
        $question = $this->getDoctrine()
            ->getRepository('QuestionBundle:Question')
            ->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        return $this->render('QuestionBundle:Question:about.html.twig', [
            'question' => $question
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        // create a question and give it some dummy data for this example
        $question = new Question();

        /** @var Form $form */
        $form = $this->createFormBuilder($question)
            ->add('title', TextType::class, ['label' => 'Title'])
            ->add('tag', TextType::class, ['label' => 'Tag', 'required' => false])
            ->add('suggestions', CollectionType::class, array(
                'label' => false,
                'entry_type'   => SuggestionType::class,
                'allow_add'    => true,
                'by_reference' => false,
            ))
            ->add('save', SubmitType::class, ['label' => 'Create'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $this->get('security.token_storage')->getToken()->getUser();
            /** @var Question $question */
            $question = $form->getData();
            $question->setUser($user);
            $question->setType(1);
            $question->setCreatedAt(new \DateTime('now', new \DateTimeZone('UTC')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question_view', ['id' => $question->getId()]);
        }

        return $this->render('QuestionBundle:Question:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function listAction()
    {
        $questions = $this->getDoctrine()
            ->getRepository('QuestionBundle:Question')
            ->findBy([
                    'user' => $this->get('security.token_storage')->getToken()->getUser()->getId()
                ],
                ['createdAt' => 'DESC']);

        return $this->render('QuestionBundle:Question:list.html.twig', [
            'questions' => $questions
        ]);
    }
}
