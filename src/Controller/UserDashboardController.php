<?php

namespace App\Controller;

use App\Enum\TaskStatus;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserDashboardController extends AbstractController
{
	#[Route('/dashboard', name: 'user_dashboard')]
	public function index(TaskRepository $taskRepository): Response
	{
		$completedTasks = $taskRepository->count([
			'createdBy'   => $this->getUser(),
			'status'      => TaskStatus::COMPLETED,
		]);

		$pendingTasks = $taskRepository->count([
			'createdBy'   => $this->getUser(),
			'status'      => TaskStatus::PENDING,
		]);

		$recentTasks = $taskRepository->findBy(
			['createdBy' => $this->getUser()],
			['dueDate'   => 'ASC'],
			5
		);

		return $this->render('user_dashboard/index.html.twig', [
			'completedTasks' => $completedTasks,
			'pendingTasks'   => $pendingTasks,
			'recentTasks'    => $recentTasks,
		]);
	}
}
