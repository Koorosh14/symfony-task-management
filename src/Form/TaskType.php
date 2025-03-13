<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title')
			->add('description')
			->add('status', ChoiceType::class, [
				'choices' => [
					'Pending' => TaskStatus::PENDING,
					'In Progress' => TaskStatus::IN_PROGRESS,
					'Completed' => TaskStatus::COMPLETED,
				],
			])
			->add('isImportant')
			->add('dueDate', null, [
				'widget' => 'single_text',
			])
			->add('assignedTo', EntityType::class, [
				'class' => User::class,
				'choice_label' => 'name',
				'multiple' => true,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Task::class,
		]);
	}
}
