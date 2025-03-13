<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title')
			->add('description')
			->add('status')
			->add('isImportant')
			->add('dueDate', null, [
				'widget' => 'single_text',
			])
			->add('parentId')
			->add('createdAt', null, [
				'widget' => 'single_text',
			])
			->add('updatedAt', null, [
				'widget' => 'single_text',
			])
			->add('createdBy', EntityType::class, [
				'class' => User::class,
				'choice_label' => 'id',
			])
			->add('assignedTo', EntityType::class, [
				'class' => User::class,
				'choice_label' => 'id',
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
