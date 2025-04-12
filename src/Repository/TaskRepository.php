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
	 * Returns tasks created by and assigned to the given user (with filters and sorting).
	 *
	 * @param	User	$user
	 * @param	array	$filters
	 *
	 * @return	Task[]
	 */
	public function findTasksByUser(User $user, array $filters = []): array
	{
		$queryBuilder = $this->createQueryBuilder('t')
			->leftJoin('t.assignedTo', 'u') // Join with the assignedTo relationship
			->where('t.createdBy = :user') // Tasks created by the user
			->orWhere('u.id = :user') // Tasks assigned to the user
			->setParameter('user', $user);

		if (($status = $filters['status']) && in_array(strtoupper($status), ['PENDING', 'IN_PROGRESS', 'COMPLETED']))
		{
			$queryBuilder
				->andWhere('t.status = :status')
				->setParameter('status', strtoupper($status));
		}

		$sort   = in_array($filters['sort'], ['title', 'dueDate', 'status', 'createdAt', 'isImportant']) ? $filters['sort'] : 'dueDate';
		$sortBy = in_array(strtoupper($filters['sort_by']), ['ASC', 'DESC']) ? strtoupper($filters['sort_by']) : 'dueDate';

		$queryBuilder->orderBy('t.' . $sort, $sortBy);

		return $queryBuilder->getQuery()->getResult();
	}
}
