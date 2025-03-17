<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
	public function new(Request $request, EntityManagerInterface $entityManager): Response
	{
		$task = new Task();

		$form = $this->createForm(TaskType::class, $task);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			// Temporarily select a random user, will fix this later
			$task->setCreatedBy($entityManager->getRepository(User::class)->findOneBy([]));

			$entityManager->persist($task);
			$entityManager->flush();

			$this->addFlash('success', 'Task created successfully!');

			return $this->redirectToRoute('tasks_index', ['id' => $task->getId()]);
		}

		return $this->render('task/new.html.twig', [
			'form' => $form,
		]);
	}
}
