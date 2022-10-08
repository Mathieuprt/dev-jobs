<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Offres;
use App\Entity\Societe;
use App\Form\OffreType;
use App\Form\SocieteType;
use App\Repository\OffresRepository;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    public function add(Request $request, SocieteRepository $societeRepository, UserPasswordHasherInterface
    $passwordHasher, SluggerInterface $slugger): Response
    {
        $societe = new Societe();
        $societeForm = $this->createForm(SocieteType::class, $societe);
        $societeForm->handleRequest($request);

        if($societeForm->isSubmitted() && $societeForm->isValid())
        {

            $logo = $societeForm->get('logo')->getData();
            $logoName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
            $safeLogoName = $slugger->slug($logoName);
            $newLogoName = $safeLogoName.'-'.uniqid().'.'.$logo->guessExtension();

            $logo->move(
                $this->getParameter('files_directory'),
                $newLogoName
            );

            $societe
                ->setRoles(['ROLE_SOCIETY'])
                ->setLogo($newLogoName)
                ->setPassword($passwordHasher->hashPassword($societe, $societe->getPassword()));

            $societeRepository->add($societe, true);

            $this->addFlash('success', 'Votre société a bien été crée !');

            return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('societe/add.html.twig', [
            'societe_form' => $societeForm->createView(),
            'societe' => $societe
        ]);
    }
    /**
     * @Route("/{societe}", name="show", methods={"GET"}, requirements={"id":"\d+"})
     */

    public function show(Societe $societe, Offres $offres): Response
    {
        return $this->render('societe/show.html.twig', [
            'societe' => $societe,
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/{societe}/modifier", name="edit", methods={"GET", "POST"})
     */

    public function edit(Societe $societe, Request $request, SocieteRepository $societeRepository): Response
    {
        $societeForm = $this->createForm(SocieteType::class, $societe, ['etapes' => 'edit_profil']);
        $societeForm->handleRequest($request);

        if ($societeForm->isSubmitted() && $societeForm->isValid()) {
            $societeRepository->add($societe, true);

            $this->addFlash('success', 'Modifications réussies !');

            return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('societe/edit.html.twig', [
            'societe_form' => $societeForm->createView(),
            'societe' => $societe,
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





    // Ajouter une offre


    /**
     * @Route("/{societe}/creer-offre", name="add-offre", methods={"GET", "POST"})
     */
    public function addOffre(Request $request, OffresRepository $offresRepository, Societe $societe): Response
    {
        $offre = new Offres();
        $offreForm = $this->createForm(OffreType::class, $offre);
        $offreForm->handleRequest($request);

        if($offreForm->isSubmitted() && $offreForm->isValid())
        {

            $offre
                ->setSociete($societe)
                ->setCreatedAt(new \DateTimeImmutable('now'));
            $offresRepository->add($offre, true);

            $this->addFlash('success', 'Votre annonce a bien été publiée !');

            return $this->redirectToRoute('societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/add.html.twig', [
            'offre_form' => $offreForm->createView(),
            'societe' => $societe,
            'offre' => $offre,
        ]);

    }


    /**
     * @Route("/{societe}/offre", name="offres", methods={"GET", "POST"})
     */

    /*public function societeOffres(Societe $societe): Response
    {
        return $this->render('offre/societe-offres.html.twig', [
            'societe' => $societe
        ]);
    }*/

}
