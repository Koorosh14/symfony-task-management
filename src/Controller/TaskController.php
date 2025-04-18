<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
	#[Route('/tasks', name: 'tasks_index')]
	public function index(TaskRepository $taskRepository, Request $request, PaginatorInterface $paginator): Response
	{
		// Get filters from URL parameters
		$filters = [
			'search'    => $request->query->get('search'),
			'status'    => $request->query->get('status'),
			'sort'      => $request->query->get('sort', 'dueDate'),
			'sort_by'   => $request->query->get('sort_by', 'ASC'),
		];

		$query = $taskRepository->findTasksByUser($this->getUser(), $filters, true);

		return $this->render('task/index.html.twig', [
			'pagination'     => $paginator->paginate($query, $request->query->getInt('page', 1), 10),
			'currentFilters' => $filters,
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
			$task->setCreatedBy($this->getUser());

			$entityManager->persist($task);
			$entityManager->flush();

			$this->addFlash('success', 'Task created successfully!');

			return $this->redirectToRoute('task_show', ['id' => $task->getId()]);
		}

		return $this->render('task/new.html.twig', [
			'form' => $form,
		]);
	}

	#[Route('/tasks/{id<\d+>}/edit', name: 'task_edit')]
	public function edit(Task $task, Request $request, EntityManagerInterface $entityManager): Response
	{
		if ($task->getCreatedBy() !== $this->getUser())
		{
			$this->addFlash('error', 'You can\'t edit this task!');

			return $this->redirectToRoute('tasks_index');
		}

		$form = $this->createForm(TaskType::class, $task);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$entityManager->flush();

			$this->addFlash('success', 'Task updated successfully!');

			return $this->redirectToRoute('task_show', ['id' => $task->getId()]);
		}

		return $this->render('task/edit.html.twig', [
			'form' => $form,
			'task' => $task,
		]);
	}

	#[Route('/tasks/{id<\d+>}/delete', name: 'task_delete', methods: ['POST'])]
	public function delete(Task $task, Request $request, EntityManagerInterface $entityManager): Response
	{
		if ($task->getCreatedBy() !== $this->getUser())
		{
			$this->addFlash('error', 'You can\'t delete this task!');

			return $this->redirectToRoute('tasks_index');
		}

		// Check CSRF token for security
		if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token')))
		{
			$entityManager->remove($task);
			$entityManager->flush();

			$this->addFlash('success', 'Task deleted successfully!');
		}

		return $this->redirectToRoute('tasks_index');
	}
}
