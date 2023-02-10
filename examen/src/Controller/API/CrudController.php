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
        $allId = $em->getRepository(Breweries::class)->findAll();
        $incrementedId = $allId[count($allId) - 1]->getId();

        $toCamelCase = [];

        if(isset($data['INIT_BEER'])){
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
            // $em->getRepository(Beers::class)->insert($toCamelCase['initBeer']);
        }else{
            $toCamelCase = [
                'name' => $data['NAME'],
                'city' => $data['CITY'],
                'state' => $data['STATE']
            ];
        }
        
        $em->getRepository(Breweries::class)->insert($toCamelCase, $incrementedId);
        return $this->json(['MESSAGE' => "Brewery " . $toCamelCase['name'] . " inserted succesfully"]);
        // return $this->json($data);
    }

    // #[Route('/update/{id}', name: 'registration_update', methods: ['PUT'])]
    // public function update(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);
    //     $entityManager->getRepository(Registration::class)->update($id, $data);
    //     return $this->json(['MESSAGE' => "Registro " . $data["courseId"] . " modificado exitosamente"]);
    // }

    // #[Route('/delete/{id}', name: 'student_delete', methods: ['DELETE'])]
    // public function delete(int $id, EntityManagerInterface $em): JsonResponse
    // {
    //     $student = $em->getRepository(Student::class);
    //     $student->delete($id);
    //     return $this->json(['MESSAGE' => "Estudiante " . $id . " eliminado exitosamente"]);
    // }

    // #[Route('/breweries', name: 'registrations', methods: ['GET'])]
    // public function all(EntityManagerInterface $em): JsonResponse
    // {
    //     $results = $em->getRepository(Registration::class)->findAll();
    //     $data = [];
    //     foreach ($results as $regis) {
    //         $data[] = [
    //             'COURSE_ID' => $regis->getCourseId(),
    //             'STUDENT' => [
    //                 'ID' => $regis->getStudentId()->getStudentId(),
    //                 'RANK' => $regis->getStudentId()->getRanking()
    //             ],
    //             'GRADE' => $regis->getGrade(),
    //             'SAT' => $regis->getSat()
    //         ];
    //     }
    //     return $this->json($data);
    // }

    // #[Route('/student/{id}', name: 'student', methods: ['GET'])]
    // public function single(int $id, EntityManagerInterface $em): JsonResponse
    // {
    //     $student = $em->getRepository(Student::class)->find($id);
    //     $registrations = $em->getRepository(Registration::class)->findBy(["studentId" => $id]);
    //     $arrayRegistros = [];
    //     for ($i = 0; $i < count($registrations); $i++) {
    //         $arrayRegistros += [
    //             'REGISTRO ' . ($i + 1) => [
    //                 'ID' => $registrations[$i]->getCourseId(),
    //                 'GRADE' => $registrations[$i]->getGrade()
    //             ]
    //         ];
    //     }
    //     $data[] = [
    //         'STUDENT_ID' => $student->getStudentId(),
    //         'INTELLIGENCE' => $student->getIntelligence(),
    //         'RANKING' => $student->getRanking(),
    //         'REGISTROS_ASOCIADOS' => $arrayRegistros
    //     ];


    //     return $this->json($data);
    // }
}
