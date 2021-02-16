<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\Niveau;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetenceController extends AbstractController
{
//  /**
//      * @var EntityManagerInterface
//      */
//     private EntityManagerInterface $manager;
//     /**
//      * @var GroupeCompetenceRepository
//      */
//     private GroupeCompetenceRepository $grpecompetences;
//     /**
//      * @var CompetenceRepository
//      */
//     private CompetenceRepository $competenceRepository;
//     /**
//      * @var Request
//      */
//     private Request $request;
//     /**
//      * @var SerializerInterface
//      */
//     private SerializerInterface $serializer;
//     /**
//      * @var CompetenceRepository
//      */
//     private CompetenceRepository $CompetenceRepository;

//     /**
//      * GroupeCompetenceController constructor.
//      * @param EntityManagerInterface $manager
//      * @param GroupeCompetenceRepository $grpecompetences
//      * @param CompetenceRepository $competenceRepository
//      * @param SerializerInterface $serializer
//      */
//     public function __construct(EntityManagerInterface $manager,GroupeCompetenceRepository $grpecompetences
//         ,CompetenceRepository $competenceRepository,SerializerInterface $serializer)
//     {
//         $this->manager = $manager;
//         $this->grpecompetences =$grpecompetences;
//         $this->CompetenceRepository = $competenceRepository;
//         $this->serializer = $serializer;
//     }

/**
     * @Route(
     *     "/api/admin/grpecompetences",
     *      name="groupcompadd",
     *     methods={"POST",},
     *     defaults={
     *      "_api_resource_class"=GroupeCompetence::class,
     *      "_api_collection_operation_name"="AddGroupeCompetences"
     *     }
     *     )
     */
 /*  public function AddGroupeCompetences( Request $request, SerializerInterface $serializer ){
     $compObject= $request->request->all();

     $compObject = $serializer->denormalize($compObject, "App\Entity\GroupeCompetence");
     

      $groupeCompetene = new GroupeCompetence();
      $compObject->setLibelle('libelle');
      $compObject->setDescription('description');
      $compObject->setStatut(false);
      foreach ($groupeCompetene as $competence) {
          dd($competence);
          if ($this->competenceRepository->findOneBy(['libelle' => $competence['libelle']])) {
              $objCompetence = $this->competenceRepository->findOneBy(['libelle' => $competence['libelle']]);

              $compObject->addCompetence($objCompetence);
              $this->manager->persist($compObject);
          } 
        //   else 
        //   {
    //           if (isset($compObject['competence'][0]['niveau'])) {
    //               $data = $compObject['competence'][0]['niveau'];
    //               //dd(count($data));
    //               foreach ($compObject['competence'] as $objetCompetence) {
    //                   $competence = new Competence();
    //                   $competence->setLibelle($objetCompetence['libelle']);

    //                   foreach ($data as $objetniveau) {
    //                       //dd($objetniveau);
    //                       $niveau = new Niveau();
    //                       $niveau->setLibelle($objetniveau['libelle']);
    //                           $competence->addNiveau($niveau);
    //                           $this->manager->persist($niveau);

    //                       }
    //                   $this->manager->persist($competence);
    //                   $groupeCompetene->addCompetence($competence);
    //                   $this->manager->persist($groupeCompetene);
    //               }

    //           }
    //           $this->manager->flush();
    //       }
    //       return $this->json("valider");

      }
  } */

}
