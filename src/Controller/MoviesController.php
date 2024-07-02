<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies', name: 'app_movies', defaults:['name'=>null], methods: ['GET', 'HEAD'])]
    public function index($name): Response
    {
        $movies = ["SpiderMan","Avengers","Basterds","Robot"];
        return $this->render('index.html.twig',[
            "movies"=>$movies
        ]);
    }
}
