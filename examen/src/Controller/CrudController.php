<?php

namespace App\Controller;

use App\Entity\Breweries;
use App\Entity\Beers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CrudController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function main(): Response
    {
        return $this->render('main.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    #[Route('/breweries/{page?}', name: 'app_breweries')]
    public function breweries(?int $page, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $BreweryData = $em->getRepository(Breweries::class);
        return $this->render('breweries.html.twig', [
            'data' => $BreweryData->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    private function getLastPage($page, $session): int
    {
      if ($page != null) {
        $session->set("page",$page);
        return $page;
      } elseif (!$session->has("page") || !is_numeric($session->get("page"))) {
        $session->set("page",1);
        return 1;
      }
      return $session->get("page");
    }

    #[Route('/detail/{id}', name: 'app_detail')]
    public function breweryDetail(?int $id ,EntityManagerInterface $em): Response
    {
        $breweryRepository = $em->getRepository(Breweries::class)->find($id);
        $beerRepository =  $em->getRepository(Beers::class)->findBy(["breweryId" => $id]);
        return $this->render('breweryDetail.html.twig', [
            'breweryData' => $breweryRepository,
            'beerData' => $beerRepository
        ]);
    }
}
