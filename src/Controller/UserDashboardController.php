<?php

namespace App\Controller;

use App\Enum\TaskStatus;
use App\Form\ProfileFormType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

	#[Route('/dashboard/edit-profile', name: 'user_edit_profile')]
	public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
	{
		$user = $this->getUser();
		$form = $this->createForm(ProfileFormType::class, $user);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$entityManager->flush();

			$this->addFlash('success', 'Profile updated successfully!');

			return $this->redirectToRoute('user_dashboard');
		}

		return $this->render('user_dashboard/edit_profile.html.twig', [
			'form' => $form->createView()
		]);
	}
}
