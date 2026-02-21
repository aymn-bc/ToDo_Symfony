<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{
    #[Route('/tache', name: 'app_tache')]
    public function index(TacheRepository $tacheRepository): Response
    {   
        $taches = $tacheRepository->findAll();
        return $this->render('tache/index.html.twig', [
            'taches' => $taches
        ]);
    }

    #[Route('/tache/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(EntityManagerInterface $em) : Response
    {
        $tache = new Tache();
        $tache->setTitre('Mon premier tache');
        $tache->setDescription('Ceci est le contenu de mon premier tache créé avec Doctrine.');
        $tache->setDateCreation(new \DateTime());
        $tache->setTerminee(false);

        $em->persist($tache);
        $em->flush();

        return new Response("Tache créé avec l'id : " . $tache->getId());
    }

    #[Route('/tache/{id}', name: 'app_tache_details', requirements: ['id' => '\d+'])]
    public function details(Tache $tache): Response{
        return $this->render('tache/detail.html.twig', [
            'tache' => $tache
        ]);
    }
}
