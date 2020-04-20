<?php

namespace App\Controller;

use App\Entity\GameResult;
use App\Form\GameResultType;
use App\Repository\GameResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gameresult")
 */
class GameResultController extends AbstractController
{
    /**
     * @Route("/", name="game_result_index", methods={"GET"})
     */
    public function index(GameResultRepository $gameResultRepository): Response
    {
        return $this->render('game_result/index.html.twig', [
            'game_results' => $gameResultRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_result_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gameResult = new GameResult();
        $form = $this->createForm(GameResultType::class, $gameResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameResult);
            $entityManager->flush();

            return $this->redirectToRoute('game_result_index');
        }

        return $this->render('game_result/new.html.twig', [
            'game_result' => $gameResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_result_show", methods={"GET"})
     */
    public function show(GameResult $gameResult): Response
    {
        return $this->render('game_result/show.html.twig', [
            'game_result' => $gameResult,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_result_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameResult $gameResult): Response
    {
        $form = $this->createForm(GameResultType::class, $gameResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_result_index');
        }

        return $this->render('game_result/edit.html.twig', [
            'game_result' => $gameResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_result_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameResult $gameResult): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameResult->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameResult);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_result_index');
    }
}
