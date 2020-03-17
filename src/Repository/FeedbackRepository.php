<?php

namespace App\Repository;

use App\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Feedback::class);
        $this->manager = $manager;
    }

    public function saveFeedback($firstName, $lastName, $message): Feedback
    {
        $newFeedback = new Feedback();

        $newFeedback
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setMessage($message);

        $this->manager->persist($newFeedback);
	$this->manager->flush();

	return $newFeedback;
    }

    public function getFilteredFeedback() {
	    $feedbacks = $this->manager->createQuery(
		    "SELECT f
		    FROM App\Entity\Feedback f
		    WHERE f.message NOT LIKE :forbidden_word1
			AND f.message NOT LIKE :forbidden_word2"
	    )
	    ->setMaxResults(10)
	    ->setParameter('forbidden_word1', '%test1%')
	    ->setParameter('forbidden_word2', '%test2%')
	    ->getResult();

    	    return $feedbacks;
    }
}
