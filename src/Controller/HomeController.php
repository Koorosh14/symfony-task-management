<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
	#[Route('/', name: 'app_home')]
	public function index(): Response
	{
		$features = [
			[
				'title' => 'Task Management',
				'description' => 'Create, edit, and organize tasks. Set priorities, due dates, and track your progress.',
				'icon' => 'clipboard-list'
			],
			[
				'title' => 'Priority Levels',
				'description' => 'Set priority levels for tasks to focus on what matters most.',
				'icon' => 'flag'
			],
			[
				'title' => 'Due Date Tracking',
				'description' => 'Never miss a deadline with our intuitive due date system.',
				'icon' => 'calendar'
			]
		];

		return $this->render('home/index.html.twig', [
			'features' => $features
		]);
	}
}
