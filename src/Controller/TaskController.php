<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
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

	#[Route('/tasks/{id<\d+>}', name: 'task_show')]
	public function show(Task $task): Response
	{
		return $this->render('task/show.html.twig', [
			'task' => $task,
		]);
	}

	#[Route('/tasks/new', name: 'task_new')]
	public function new(): Response
	{
		$form = $this->createForm(TaskType::class);

		return $this->render('task/new.html.twig', [
			'form' => $form,
		]);
	}
}
