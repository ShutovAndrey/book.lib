<?php

namespace App\Controller;

use App\Controller\AuthorsController;
use App\Entity\Book;
use App\Entity\Author;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request, AuthorRepository $authorRepository, AuthorsController $authorsController): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->checking($request, $book, $authorRepository, $authorsController);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('book_index');
        }
        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book, AuthorRepository $authorRepository, AuthorsController $authorsController): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->checking($request, $book, $authorRepository, $authorsController);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('book_index');
        }
        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }
        return $this->redirectToRoute('book_index');
    }

    private function checking(object $request, object $book, object $authorRepository, object $authorsController): void
    {
        $requestAuthor = $request->get('author');
        $newAuthor = $authorRepository->findOneBy(['name' => $requestAuthor]);
        //if author exist -> set it, if no -> create
        if (!$newAuthor) {
            $book->setAuthor($authorsController->createAuthor($requestAuthor));
        } else {
            $book->setAuthor($newAuthor);
        }
    }
}
