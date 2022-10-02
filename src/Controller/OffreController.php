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
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @Route("/{offre}/modifier", name="edit", methods={"GET", "POST"})
     */
    public function edit(Offres $offre, Request $request, OffresRepository $offresRepository): Response
    {
        $offreForm = $this->createForm(OffreType::class, $offre);
        $offreForm->handleRequest($request);

        if ($offreForm->isSubmitted() && $offreForm->isValid())
        {
            $offresRepository->add($offre, true);

            $this->addFlash('success', 'L\'offre a été modifiée !');

            return $this->redirectToRoute('offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig',[
            'offre_form' => $offreForm,
            'offre' => $offre
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

        return $this->redirectToRoute('offre_index', [], Response::HTTP_SEE_OTHER);
    }


    // Candidature

    /**
     * @Route("/{offre}/candidature", name="candidature", methods={"GET", "POST"})
     */
    public function candidature(Offres $offre, Request $request, CandidatRepository $candidatRepository, SluggerInterface $slugger):
    Response
    {
        $candidat = new Candidat();
        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);

        if($candidatForm->isSubmitted() && $candidatForm->isValid())
        {

            $cv = $candidatForm->get('candidat_cv')->getData();
            $cvName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
            $safeLogoName = $slugger->slug($cvName);
            $newCvName = $safeLogoName.'-'.uniqid().'.'.$cv->guessExtension();

            $cv->move(
                $this->getParameter('files_directory'),
                $newCvName
            );

            $candidat
                ->setOffre($offre)
                ->setCandidatCv($newCvName)
                ->setCreatedAt(new \DateTimeImmutable('now'));

            $candidatRepository->add($candidat, true);

            $this->addFlash('success', 'Votre candidature a bien été envoyé !');

            return $this->redirectToRoute('offre_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('candidat/candidature.html.twig', [
            'candidat_form'=>$candidatForm->createView(),
            'candidat' => $candidat
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
