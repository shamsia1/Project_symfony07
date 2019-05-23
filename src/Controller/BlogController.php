<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;



class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/blog",name="app_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * @Route("/blog/list/{page}",
     *     requirements={"page"="\d+"},
     *     defaults={"page"=1},
     *     name="blog_list"
     * )
     */

    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }

    public function new()
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'blog_list', correspondant à l'url /blog/list/5
        return $this->redirectToRoute('blog_list',['page' => 5]);
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/show/{slug}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @return Response A response instance
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.');
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
    // * @Route("blog/category/{categoryName}", name="show_category")
     //* @return Response A response instance
    // * @ParamConverter("categoryName", class="App\Entity\Category")
    // */

    //public function showByCategory(string $categoryName): Response
   // {


        //$category= $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
        // old $categoryArticles = $this->getDoctrine()->getRepository(Article::class)->findBy(['category' => $categoryName
        // old ], ['id' => 'DESC'], 3);
       // $categoryArticles = $category->getArticles();
        //return $this->render('blog/category.html.twig', ['categoryArticle' => $categoryArticles]);


   // }


    /**
     * @route("/blog/category/{name}",
     *      name="category_show"),
     * @ParamConverter("categoryName", class="App\Entity\Category")
     */
    public function showByCategory(Category $categoryName): Response
    {
        $articles = $categoryName->getArticles();
        return $this->render(
            'blog/category.html.twig',
            ['category' => $categoryName,
                'articles' => $articles, ]);
    }
}

