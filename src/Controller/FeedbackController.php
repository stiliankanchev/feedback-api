<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Feedback;

class FeedbackController extends AbstractController {
	/**
	 * @Route("/feedback", methods={"POST"})
	 */
	public function create(Request $request) {
		$entityManager = $this->getDoctrine()->getManager();

		$requestBody = json_decode($request->getContent(), true);	

		$feedback = $entityManager->getRepository(Feedback::class)
			->saveFeedback(
				$requestBody['firstName'],
				$requestBody['lastName'],
				$requestBody['message']
			);

		return new JsonResponse($feedback->jsonSerialize(), Response::HTTP_CREATED);
	}

	/**
	 * @Route("/feedback", methods={"GET"})
	 */
	public function getAll() {
		$entityManager = $this->getDoctrine()->getManager();
		$filteredFeedbacks = $entityManager->getRepository(Feedback::class)
			->getFilteredFeedback();

		$feedbacksAsJson = array_map(function($feedback) { return $feedback->jsonSerialize(); }, $filteredFeedbacks);
		return new JsonResponse($feedbacksAsJson, Response::HTTP_OK);
	}

}
