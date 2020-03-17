<?php

namespace App\Tests\Repository;

use App\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeedbackRepositoryTest extends KernelTestCase {
	private $entityManager;

	protected function setUp(): void {
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()
			->get('doctrine')
			->getManager();
		// $this->entityManager->getConnection()->beginTransaction();
		$this->entityManager->getRepository(Feedback::class)->createQueryBuilder('f')->delete()->getQuery()->execute();
	}

	public function testGetFilteredFeedback() {
		$feedbackRepository = $this->entityManager->getRepository(Feedback::class);
		$feedbackRepository->saveFeedback('Pesho', 'Peshev', 'Hi there');

		$feedbacks = $feedbackRepository->getFilteredFeedback();

		$this->assertSame(count($feedbacks), 1);
		$this->assertSame($feedbacks[0]->getFirstName(), 'Pesho');
		$this->assertSame($feedbacks[0]->getLastName(), 'Peshev');
		$this->assertSame($feedbacks[0]->getMessage(), 'Hi there');
	}

	protected function tearDown(): void {
		parent::tearDown();
		$this->entityManager->getRepository(Feedback::class)->createQueryBuilder('f')->delete()->getQuery()->execute();
		// $this->entityManager->getConnection()->rollback();
		$this->entityManager->close();
		$this->entityManager = null;
	}
}

