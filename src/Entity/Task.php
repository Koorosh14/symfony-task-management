<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Enum\TaskStatus;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 512)]
	#[Assert\NotBlank]
	private ?string $title = null;

	#[ORM\Column(type: Types::TEXT, nullable: true)]
	private ?string $description = null;

	#[ORM\Column(enumType: TaskStatus::class)]
	#[Assert\Choice([TaskStatus::PENDING, TaskStatus::IN_PROGRESS, TaskStatus::COMPLETED])]
	private ?TaskStatus $status = TaskStatus::PENDING;

	#[ORM\Column]
	private ?bool $isImportant = false;

	#[ORM\Column(nullable: true)]
	private ?\DateTime $dueDate = null;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $createdBy = null;

	/**
	 * @var Collection<int, User>
	 */
	#[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'assignedTasks')]
	private Collection $assignedTo;

	#[ORM\Column(nullable: true)]
	#[Assert\Type('integer')]
	#[Assert\Positive]
	private ?int $parentId = null;

	#[ORM\Column]
	private ?\DateTime $createdAt = null;

	#[ORM\Column]
	private ?\DateTime $updatedAt = null;

	public function __construct()
	{
		$this->assignedTo = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): static
	{
		$this->title = $title;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): static
	{
		$this->description = $description;

		return $this;
	}

	public function getStatus(): ?TaskStatus
	{
		return $this->status;
	}

	public function setStatus(TaskStatus $status): static
	{
		$this->status = $status;

		return $this;
	}

	public function isImportant(): ?bool
	{
		return $this->isImportant;
	}

	public function setIsImportant(bool $isImportant): static
	{
		$this->isImportant = $isImportant;

		return $this;
	}

	public function getDueDate(): ?\DateTime
	{
		return $this->dueDate;
	}

	public function setDueDate(?\DateTime $dueDate): static
	{
		$this->dueDate = $dueDate;

		return $this;
	}

	public function getCreatedBy(): ?User
	{
		return $this->createdBy;
	}

	public function setCreatedBy(?User $createdBy): static
	{
		$this->createdBy = $createdBy;

		return $this;
	}

	/**
	 * @return Collection<int, User>
	 */
	public function getAssignedTo(): Collection
	{
		return $this->assignedTo;
	}

	public function addAssignedTo(User $assignedTo): static
	{
		if (!$this->assignedTo->contains($assignedTo)) {
			$this->assignedTo->add($assignedTo);
		}

		return $this;
	}

	public function removeAssignedTo(User $assignedTo): static
	{
		$this->assignedTo->removeElement($assignedTo);

		return $this;
	}

	public function getParentId(): ?int
	{
		return $this->parentId;
	}

	public function setParentId(?int $parentId): static
	{
		$this->parentId = $parentId;

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
