<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Task::class);
	}

	/**
	 * Returns tasks created by and assigned to the given user.
	 *
	 * @param	User	$user
	 *
	 * @return	Task[]
	 */
	public function findTasksByUser(User $user): array
	{
		return $this->createQueryBuilder('t')
			->leftJoin('t.assignedTo', 'u') // Join with the assignedTo relationship
			->where('t.createdBy = :user') // Tasks created by the user
			->orWhere('u.id = :user') // Tasks assigned to the user
			->setParameter('user', $user)
			->getQuery()
			->getResult();
	}
}
