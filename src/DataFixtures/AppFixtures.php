<?php

namespace App\DataFixtures;

use App\Entity\Log;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskStatus;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$user = new User();
		$user->setEmail('Admin@Test.com');
		$user->setPassword('12345');
		$user->setName('Admin');
		$user->setRole(UserRole::ADMIN);
		$user->setIsActive(true);

		$manager->persist($user);

		$log = new Log();
		$log->setAction('user_created');
		$log->setUserId($user);

		$manager->persist($log);

		$task = new Task();
		$task->setTitle('Test Task');
		$task->setDescription('Test Description');
		$task->setStatus(TaskStatus::IN_PROGRESS);
		$task->setCreatedBy($user);

		$manager->persist($task);

		$log = new Log();
		$log->setAction('task_created');
		$log->setUserId($user);
		$log->setTaskId($task);

		$manager->persist($log);

		$manager->flush();
	}
}
