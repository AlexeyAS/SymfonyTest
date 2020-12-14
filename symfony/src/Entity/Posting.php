<?php

namespace App\Entity;

use App\Repository\PostingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//use Symfony\Component\Security\Core\User\PostingInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Filter\PostingSearch;

/**
 * @ORM\Entity(repositoryClass=PostingRepository::class)
 */
class Posting
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $subject;

	/**
	 * @ORM\Column(type="text")
	 */
	private $message;

	/**
	 * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
	 * @ORM\GeneratedValue
	 *
	 * @var string A "Y-m-d H:i:s" formatted value
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
	 * @ORM\GeneratedValue
	 *
	 * @var string A "Y-m-d H:i:s" formatted value
	 */
	private $updatedAt;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getSubject(): ?string
	{
		return $this->subject;
	}

	public function setSubject(string $subject): self
	{
		$this->subject = $subject;

		return $this;
	}

	public function getMessage(): ?string
	{
		return $this->message;
	}

	public function setMessage(string $message): self
	{
		$this->message = $message;

		return $this;
	}

	public function getCreatedAt(): ?string
	{
		return $this->createdAt->format('Y-m-d H:i:s');
	}

	public function setCreatedAt($createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->updatedAt->format('Y-m-d H:i:s');
	}

	public function setUpdatedAt($updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getPostingsBySearch(Request $request): FormBuilderInterface
	{
		$builder = (new PostingSearch())->apply($request);
		return $builder;
	}

}
