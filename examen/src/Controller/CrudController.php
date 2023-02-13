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


    // Función que renderiza el twig 'breweries.html', cuya estructura se basa en un listado de las cervecerías registradas en base de datos. Junto con un parámetro opcional, ya que especificamos que podrá ser nulo, referenciando a la última página del paginado que el usuario ha visitado.
    // Esta página se renderizará con la ruta '/breweries'.
    // Se necesitarán pasar parámetros relacionados con:
    //  1. La última página del paginado que el usuario ha visitado.
    //  2. Un objeto EntityManagerInterface, para acceder a la información de la entidad 'Breweries'.
    //  3. Un objeto SessionInterface, para acceder a la variable de sesión que almacenará la última página del paginado que el usuario ha visitado.
    #[Route('/breweries/{page?}', name: 'app_breweries')]
    public function breweries(?int $page, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $BreweryData = $em->getRepository(Breweries::class);
        return $this->render('breweries.html.twig', [

            // Al renderizar, le pasamos un array de tipo 'Breweries' con la información de todas las cervecerías registradas.
            'data' => $BreweryData->findAll(),
            
            // y, utilizando la función getLastPage que menciono más abajo y parametrizada con el parámetro de ruta y el objeto SessionInterface, le paso (y almaceno) la última página del paginado que el usuario ha visitado.
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
