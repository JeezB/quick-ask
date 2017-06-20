<?php

namespace QuestionBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use QuestionBundle\Entity\Answer;
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
        /** @var Question $question */
        $question = $this->getDoctrine()
            ->getRepository('QuestionBundle:Question')
            ->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        $ratios = [];
        $regularRatios = [];
        $regularRatios[0] = 0;
        $regularRatios[1] = 0;
        $total = 0;
        /** @var array[Answer] $answers */
        $answers = $question->getAnswers();
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            /** @var Suggestion $suggestion */
            $suggestion = $answer->getSuggestion();
            if (!array_key_exists($suggestion->getId(), $ratios)) {
                $ratios[$suggestion->getId()] = 0;
            }

            $regularRatios[$suggestion->isCorrect()] += 1;
            $ratios[$suggestion->getId()] += 1;
            $total += 1;
        }

        $percentages = [];
        foreach ($ratios as $key => $ratio) {
            $value = 0;
            if (!$total === 0) {
                $value = (int)$ratio/(int)$total*100;
            }

            $percentages[$key] = floatval(round($value, 1));
        }

        $regularPercentages = [];
        foreach($regularRatios as $key => $ratio) {
            $value = 0;
            if (!$total === 0) {
                $value = (int)$ratio/(int)$total*100;
            }
            $regularPercentages[$key] = floatval(round($value, 1));
        }

        return $this->render('QuestionBundle:Question:about.html.twig', [
            'question' => $question,
            'ratios' => $ratios,
            'percentages' => $percentages,
            'regularPercentages' => $regularPercentages,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createQcmAction(Request $request)
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

    public function createRegularAction(Request $request)
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
            $suggestions = $question->getSuggestions();
            foreach($suggestions as $suggestion){
                $suggestion->setIsCorrect(true);
            }

            $falseSuggestion = new Suggestion();
            $falseSuggestion->setQuestion($question);
            $falseSuggestion->setIsCorrect(false);
            $falseSuggestion->setTitle('Any other answer');

            $suggestions[] = $falseSuggestion;

            // $form->getData() holds the submitted values
            $user = $this->get('security.token_storage')->getToken()->getUser();
            /** @var Question $question */
            $question = $form->getData();
            $question->setUser($user);
            $question->setType(2);
            $question->setCreatedAt(new \DateTime('now', new \DateTimeZone('UTC')));
            $question->setSuggestions($suggestions);

            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question_view', ['id' => $question->getId()]);
        }

        return $this->render('QuestionBundle:Question:newRegular.html.twig', [
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

        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('QuestionBundle:Question:list.html.twig', [
            'questions' => $questions,
            'user' => $user
        ]);
    }
}
