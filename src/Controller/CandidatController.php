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
        $candidatForm = $this->createForm(CandidatType::class, $candidat, ['etapes' => "edit_profile"]);
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

    /**
     * @Route("/{candidat}/suppression", name="delete", methods={"GET", "POST"})
     */
    public function delete(Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        $candidatRepository->remove($candidat, true);

        $this->addFlash('success', 'Le candidat a été supprimé !');

        return $this->redirectToRoute('candidat_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{candidat}", name="show", methods={"GET", "POST"}, requirements={"candidat": "\d+"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat
        ]);
    }

}
