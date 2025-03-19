<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
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
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1'],
			])
			->add('description', TextareaType::class, [
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1', 'rows' => 4],
			])
			->add('status', EnumType::class, [
				'class' => TaskStatus::class,
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1'],
			])
			->add('isImportant', CheckboxType::class, [
				'attr' => ['class' => 'mr-2'],
				'label_attr' => ['class' => 'inline-flex items-center'],
			])
			->add('dueDate', DateTimeType::class, [
				'widget' => 'single_text',
				'attr' => ['class' => 'w-full border rounded px-3 py-2 mt-1'],
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
