<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection

class Category
{
    //...
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="Category")
     */
    private $articles;

public function__construct()
{
$this->articles = new ArrayCollection();
}

//...
/**
 * @return Collection|Article[]
 */
public
function getArticles(): Collection
{
    return $this->articles;
}

public
function addArticle(Article $article): Self
{
    if (!$this->articles->contains($article)) {
        $this->articles[] = $article;
        $article->setCategory($this);
    }
    return $this;
}


/**
 * @param Article $article
 * @return Category
 */
public
function removeArticle(Article $article): Self
    {
    if ($this->articles->contains($article)) {
        $this->articles->removeElement($article);
        //set the owning side to null(unless already changed)
        if ($article->getCategory() === $this) {
            $article->setCategory(null);
        }
    }

    return $this;
    }
}



