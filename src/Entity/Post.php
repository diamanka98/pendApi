<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * 
 */
#[
    ApiResource(
        // attributes: [
        //     'validation_groups' =>[]
        // ],
        normalizationContext: ['groups' => ['read:collection']],
        denormalizationContext: ['groups' => ['write:Post']],
        paginationItemsPerPage: 2,
        paginationMaximumItemsPerPage: 2,
        paginationClientItemsPerPage: true,
        collectionOperations: [
            'get',
            'post'
        ],
        itemOperations: [
            'put' => [
                'denormalization_context' => ['groups' => ['write:Post']]
            ],
            'delete',
            'get' => [
                'normalization_context' => ['groups' => ['read:collection', 'read:item', 'read:Post']]
            ]
        ] //Choisir les operations à afficher
    ),
    ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partal'])
]
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[
        Groups(['read:collection']),
        Length(min: 5, groups: ['create:Post'])
    ]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:collection', 'write:Post'])]
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
 
     */
    #[Groups(['read:collection'])]
    private $slug;

    /**
     * @ORM\Column(type="text")
    
     */
    #[Groups(['read:item'])]
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:item'])]
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */

    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts" , cascade="persist")
     */
    #[
        Groups(['read:item', 'write:Post']),
        Valid()
    ]
    private $category;

    // public static function validationGroups(self $post)
    // {
    //     return ['create:Post'];
    // }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
