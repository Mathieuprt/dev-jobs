<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Entity\Societe;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/societes", name="societe_")
 */

class SocieteController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SocieteRepository $societeRepository): Response
    {
        return $this->render('societe/index.html.twig', [
            'controller_name' => 'SocieteController',
            'societes' => $societeRepository->findAll()
        ]);
    }


    /**
     * @Route("/creer", name="add", methods={"GET", "POST"})
     */

    public function add(Request $request, SocieteRepository $societeRepository): Response
    {
        $societe = new Societe();
        $societeForm = $this->createForm(SocieteType::class, $societe);
        $societeForm->handleRequest($request);

        if($societeForm->isSubmitted() && $societeForm->isValid())
        {
            $societe->setRoles(['ROLE_SOCIETY']);
            $societeRepository->add($societe, true);

            // add flash here

            return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('societe/add.html.twig', [
            'societe_form' => $societeForm->createView()
        ]);
    }


    /**
     * @Route("/{societe}/modifier", name="edit", methods={"GET", "POST"})
     */

    public function edit(Societe $societe, Request $request, SocieteRepository $societeRepository): Response
    {
        $societeForm = $this->createForm(SocieteType::class, $societe);

        $societeForm->handleRequest($request);

        if ($societeForm->isSubmitted() && $societeForm->isValid()) {
            $societeRepository->add($societe, true);

            // add flash

            return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('societe/edit.html.twig', [
            'societe_form' => $societeForm,
            'societe' => $societe
        ]);
    }

    /**
     * @Route("/{societe}/suppression", name="delete", methods={"GET", "POST"})
     */

    public function delete(Societe $societe, SocieteRepository $societeRepository): Response
    {
        $societeRepository->remove($societe, true);

        $this->addFlash('success', 'La société a été supprimé !');

        return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{societe}", name="show", methods={"GET", "POST"})
     */

    public function show(Societe $societe, Offres $offres): Response
    {
        return $this->render('societe/show.html.twig', [
            'societe' => $societe,
            'offre' => $offres
        ]);
    }



    // Les offres

    /**
     * @Route("/{societe}/offre", name="offres", methods={"GET", "POST"})
     */

    public function societeOffres(Societe $societe): Response
    {
        return $this->render('offre/societe-offres.html.twig', [
            'societe' => $societe
        ]);
    }




    // Les candidats


    /**
     * @Route("/{societe}/candidats", name="candidats", methods={"GET", "POST"})
     */

    public function societeCandidats(Societe $societe): Response
    {
        return $this->render('candidat/societe-candidats.html.twig', [
            'societe' => $societe
        ]);
    }
}
