<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoviesController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/movies', name: 'app_movies', defaults:['name'=>null], methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movies = $repository->findAll();

        return $this->render('./movies/index.html.twig', ['movies' => $movies]);
    }
    #[Route('/movies/create', name: 'app_create')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class,$movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();

            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName);
            }

            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('app_movies');
        }
        return $this->render('./movies/create.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/movies/edit/{id}', name: 'app_edit')]
    public function edit($id, Request $request): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($movie->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath()
                    )) {
                        $this->GetParameter('kernel.project_dir') . $movie->getImagePath();
                    }
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $movie->setImagePath('/uploads/' . $newFileName);
                    $this->em->flush();

                    return $this->redirectToRoute('app_movies');
                }
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setYear($form->get('year')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('app_movies');
            }
        }

        return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/delete/{id}', methods: ['GET', 'DELETE'], name: 'app_delete')]
    public function delete($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('app_movies');
    }
    #[Route('/movies/{id}', name: 'app_movie', methods: ['GET'])]
    public function show($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);

        return $this->render('./movies/show.html.twig', ['movie' => $movie]);
    }
}
