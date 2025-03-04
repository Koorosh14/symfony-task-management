<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
	#[Route('/tasks', name: 'tasks_index')]
	public function index(TaskRepository $taskRepository): Response
	{
		return $this->render('task/index.html.twig', [
			'tasks' => $taskRepository->findAll(),
		]);
	}
}
