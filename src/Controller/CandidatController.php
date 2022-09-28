<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidats", name="candidat_")
 */

class CandidatController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CandidatRepository $candidatRepository): Response
    {
        return $this->render('candidat/index.html.twig', [
            'controller_name' => 'CandidatController',
            'candidats' => $candidatRepository->findAll()
        ]);
    }

    /**
     * @Route("/{candidat}/modifier", name="edit", methods={"GET", "POST"})
     */

    public function edit(Candidat $candidat, Request $request, CandidatRepository $candidatRepository): Response
    {
        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);

        if($candidatForm->isSubmitted() && $candidatForm->isValid())
        {
            $candidatRepository->add($candidat, true);

            // add flash

            return $this->redirectToRoute('candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidat/edit.html.twig', [
            'candidat_form' => $candidatForm,
            'candidat' => $candidat
        ]);
    }

    public function delete(Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        $candidatRepository->remove($candidat, true);

        // add flash here

        return $this->redirectToRoute('candidat_index', [], Response::HTTP_SEE_OTHER);
    }

}
