<?php

namespace App\Controller;

use App\Entity\ChessGame;
use App\Entity\Comment;
use App\Form\ChessGameType;
use App\Repository\ChessGameRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/chessgame")
 */
class ChessGameController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }



    /**
     * @Route("/comment", name="chess_game_comment", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function processComment(): Response
    {
        $content = filter_input(INPUT_POST, 'content');

        $user = $this->getUser();

        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setMessage($content);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();




        return $this->redirectToRoute('chess_game_index');
    }



    private function getDateFromSession()
    {
        $default = $today = new \DateTime('NOW'); // today
        $dateFromSession = $this->session->get('today', $default);

        return $dateFromSession;
    }

    private function setDateInSesson($date)
    {
        $this->session->set('today', $date);
    }

    /**
     * @Route("/dateIncrement", name="chess_game_date_increment", methods={"GET"})
     */
    public function dateIncrement(): Response
    {
        $date = $this->getDateFromSession();
        $newDate = $date->modify('+1 day');
        $this->setDateInSesson($newDate);
        return $this->redirectToRoute('chess_game_index');
    }

    /**
     * @Route("/dateToday", name="chess_game_date_today", methods={"GET"})
     */
    public function dateToday(): Response
    {
        $newDate = new \DateTime('NOW');
        $this->setDateInSesson($newDate);
        return $this->redirectToRoute('chess_game_index');
    }

    /**
     * @Route("/dateDecrement", name="chess_game_date_decrement", methods={"GET"})
     */
    public function dateDecrement(): Response
    {
        $date = $this->getDateFromSession();
        $newDate = $date->modify('-1 day');
        $this->setDateInSesson($newDate);
        return $this->redirectToRoute('chess_game_index');
    }

    /**
     * @Route("/", name="chess_game_index", methods={"GET"})
     */
    public function index(ChessGameRepository $chessGameRepository): Response
    {


        // ensure a date in session ...
        $date = $this->getDateFromSession();
        $this->setDateInSesson($date);

        $template = 'chess_game/index.html.twig';
        $args = [
            'chess_games' => $chessGameRepository->findAll(),
        ];

        return $this->render($template, $args);
    }

    /**
     * @Route("/new", name="chess_game_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chessGame = new ChessGame();
        $form = $this->createForm(ChessGameType::class, $chessGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chessGame);
            $entityManager->flush();

            return $this->redirectToRoute('chess_game_index');
        }

        return $this->render('chess_game/new.html.twig', [
            'chess_game' => $chessGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chess_game_show", methods={"GET"})
     */
    public function show(ChessGame $chessGame): Response
    {
        return $this->render('chess_game/show.html.twig', [
            'chess_game' => $chessGame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chess_game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ChessGame $chessGame): Response
    {
        $form = $this->createForm(ChessGameType::class, $chessGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chess_game_index');
        }

        return $this->render('chess_game/edit.html.twig', [
            'chess_game' => $chessGame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chess_game_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ChessGame $chessGame): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chessGame->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chessGame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chess_game_index');
    }
}
