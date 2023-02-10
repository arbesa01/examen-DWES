<?php

namespace App\Controller\API;

use App\Entity\Beers;
use App\Entity\Breweries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class CrudController extends AbstractController
{

    #[Route('/breweries', name: 'brewery_insert', methods: ['POST'])]
    public function insert(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $allBreweriesId = $em->getRepository(Breweries::class)->findAll();
        $incrementedBreweryId = $allBreweriesId[count($allBreweriesId) - 1]->getId();

        $allBeersId = $em->getRepository(Beers::class)->findAll();
        $incrementedBeerId = $allBeersId[count($allBeersId) - 1]->getId();

        $toCamelCase = [];

        if (isset($data['INIT_BEER'])) {
            $toCamelCase = [
                'name' => $data['NAME'],
                'city' => $data['CITY'],
                'state' => $data['STATE'],
                'initBeer' => [
                    'name' => $data['INIT_BEER']["NAME"],
                    'style' => $data['INIT_BEER']["STYLE"],
                    'abv' => $data['INIT_BEER']["ABV"],
                    'ibu' => $data['INIT_BEER']["IBU"],
                    'ounces' => $data['INIT_BEER']["OUNCES"]
                ]
            ];
            $em->getRepository(Breweries::class)->insert($toCamelCase, $incrementedBreweryId);
            $em->getRepository(Beers::class)->insert($toCamelCase['initBeer'], $incrementedBeerId, $incrementedBreweryId);
            return $this->json(['MESSAGE' => "Brewery " . $toCamelCase['name'] . " inserted succesfully, with " . $toCamelCase['initBeer']['name'] . " as his initial beer"]);
        } else {
            $toCamelCase = [
                'name' => $data['NAME'],
                'city' => $data['CITY'],
                'state' => $data['STATE']
            ];
            $em->getRepository(Breweries::class)->insert($toCamelCase, $incrementedBreweryId);
            return $this->json(['MESSAGE' => "Brewery " . $toCamelCase['name'] . " inserted succesfully"]);
        }
    }

    #[Route('/breweries/{id}', name: 'brewery_update', methods: ['PUT'])]
    public function update(int $id, EntityManagerInterface $em, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $toCamelCase = [];
        $toCamelCase = [
            'name' => $data['NAME'],
            'city' => $data['CITY'],
            'state' => $data['STATE']
        ];
        $em->getRepository(Breweries::class)->update($toCamelCase, $id);
        return $this->json(['MESSAGE' => "Brewery " . $toCamelCase['name'] . " updated succesfully"]);
    }

    // #[Route('/delete/{id}', name: 'student_delete', methods: ['DELETE'])]
    // public function delete(int $id, EntityManagerInterface $em): JsonResponse
    // {
    //     $student = $em->getRepository(Student::class);
    //     $student->delete($id);
    //     return $this->json(['MESSAGE' => "Estudiante " . $id . " eliminado exitosamente"]);
    // }
}
