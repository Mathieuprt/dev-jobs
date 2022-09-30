<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Offres;
use App\Form\CandidatType;
use App\Form\OffreType;
use App\Repository\CandidatRepository;
use App\Repository\OffresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offres", name="offre_")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(OffresRepository $offresRepository, Request $request): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
            'offres' => $offresRepository->findAll()
        ]);
    }

    /**
     * @Route("/ajouter", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request, OffresRepository $offresRepository): Response
    {
        $offre = new Offres();
        $offreForm = $this->createForm(OffreType::class, $offre);
        $offreForm->handleRequest($request);

        if($offreForm->isSubmitted() && $offreForm->isValid())
        {
            $offresRepository->add($offre, true);

            return $this->redirectToRoute('offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/add.html.twig', [
            'offre_form' => $offreForm->createView()
        ]);

    }


    /**
     * @Route("/{offre}/modifier", name="edit", methods={"GET", "POST"})
     */
    public function edit(Offres $offres, Request $request, OffresRepository $offresRepository): Response
    {
        $offreForm = $this->createForm(OffreType::class, $offres);
        $offreForm->handleRequest($request);

        if ($offreForm->isSubmitted() && $offreForm->isValid())
        {
            $offresRepository->add($offres, true);

            return $this->redirectToRoute('offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig',[
            'offre_form' => $offreForm,
            'offres' => $offres
        ]);
    }

    /**
     * @Route("/{offre}", name="show", methods={"GET", "POST"})
     */
    public function show(Offres $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre
        ]);
    }

    /**
     * @Route("/{offres}/suppression", name="delete", methods={"GET", "POST"})
     */

    public function delete(Offres $offres, OffresRepository $offresRepository): Response
    {
        $offresRepository->remove($offres, true);

        $this->addFlash('success', 'L\'offre a été supprimé !');

        return $this->redirectToRoute('offres_index', [], Response::HTTP_SEE_OTHER);
    }


    // Candidature

    /**
     * @Route("/{offre}/candidature", name="candidature", methods={"GET", "POST"})
     */
    public function candidature(Offres $offres, Request $request, CandidatRepository $candidatRepository): Response
    {
        $candidat = new Candidat();
        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);

        if($candidatForm->isSubmitted() && $candidatForm->isValid())
        {
            $candidat->setOffre($offres);

            $candidatRepository->add($candidat, true);

            return $this->redirectToRoute('offres_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('candidat/candidature.html.twig', [
            'candidat_form'=>$candidatForm->createView()
        ]);
    }

    /**
     * @Route("/{offre}/{candidat}", name="candidat_show", methods={"GET", "POST"})
     */
    /*public function showCandidat(Candidat $candidat, Offres $offre): Response
    {
        return $this->render('candidat/show.html.twig', [
            'offre' => $offre,
            'candidat' => $candidat
        ]);
    }*/
}
