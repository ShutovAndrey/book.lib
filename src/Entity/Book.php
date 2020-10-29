<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Author;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      minMessage = "Некорректный год издания",
     *      maxMessage = "Некорректный год издания"
     * )
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="book")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAuthor(): ?Author
{

    return $this->author;
}

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

}
