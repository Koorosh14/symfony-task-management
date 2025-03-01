<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 50)]
	private ?string $action = null;

	#[ORM\Column(type: Types::TEXT, nullable: true)]
	private ?string $details = null;

	#[ORM\ManyToOne]
	private ?User $userId = null;

	#[ORM\ManyToOne]
	private ?Task $taskId = null;

	#[ORM\Column]
	private ?\DateTime $createdAt = null;

	#[ORM\Column]
	private ?\DateTime $updatedAt = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getAction(): ?string
	{
		return $this->action;
	}

	public function setAction(string $action): static
	{
		$this->action = $action;

		return $this;
	}

	public function getDetails(): ?string
	{
		return $this->details;
	}

	public function setDetails(?string $details): static
	{
		$this->details = $details;

		return $this;
	}

	public function getUserId(): ?User
	{
		return $this->userId;
	}

	public function setUserId(?User $userId): static
	{
		$this->userId = $userId;

		return $this;
	}

	public function getTaskId(): ?Task
	{
		return $this->taskId;
	}

	public function setTaskId(?Task $taskId): static
	{
		$this->taskId = $taskId;

		return $this;
	}

	public function getCreatedAt(): ?\DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTime $createdAt): static
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(\DateTime $updatedAt): static
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}
}
