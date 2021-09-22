<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $articleRepository;
    private $categoryRepository;

    public function __construct(ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository; 
        $this->categoryRepository = $categoryRepository; 
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'articles'   => $articles,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function category(?Category $category): Response
    {   
        if($category) {
            $articles = $category->getArticles()->getValues();
        } else {
            return $this->redirectToRoute("home");
        }

        $categories = $this->categoryRepository->findAll();        
        return $this->render('home/index.html.twig', [
            'articles'   => $articles,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/show/{id} ", name="show")
     */
    public function show(Article $article): Response
    {
        if(!$article) {
            return $this->redirectToRoute("home");
        }
               
        return $this->render('show/index.html.twig', [
            'article' => $article,
        ]);
    }
}