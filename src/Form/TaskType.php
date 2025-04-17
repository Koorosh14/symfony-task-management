<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title', TextType::class, [
				'label' => 'Task Title',
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1'],
			])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'required' => false,
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1', 'rows' => 4],
			])
			->add('status', ChoiceType::class, [
				'label' => 'Status',
				'choices' => [
					'Pending' => TaskStatus::PENDING,
					'In Progress' => TaskStatus::IN_PROGRESS,
					'Completed' => TaskStatus::COMPLETED,
				],
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1'],
			])
			->add('isImportant', CheckboxType::class, [
				'label' => 'Mark as Important',
				'required' => false,
				'attr' => ['class' => 'mr-2'],
				'label_attr' => ['class' => 'inline-flex items-center'],
			])
			->add('dueDate', DateTimeType::class, [
				'label' => 'Due Date',
				'required' => false,
				'widget' => 'single_text',
				'attr' => [
					'class'       => 'flatpickr-input w-full border rounded px-3 py-2 mt-1',
					'placeholder' => 'Select a date and time'
				],
			])
			->add('assignedTo', EntityType::class, [
				'label' => 'Assigned to',
				'required' => false,
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
