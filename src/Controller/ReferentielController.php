<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Repository\GroupeCompetenceRepository;
use App\Repository\ReferentielRepository;
use App\Repository\ReferentilRepository;
use App\Services\ServicePhoto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ReferentielController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, GroupeCompetenceRepository $groupeCompRepo, SerializerInterface $serialize)
    {
        $this->manager = $manager;
        $this->serialize = $serialize;
        $this->groupeCompetenceRepository = $groupeCompRepo;
    }
 


    /**
     * @Route(
     *      name="postRef",
     *      path="/api/admin/referentiels",
     *      defaults={
     *          "__controller"="App\Controller\ReferentielController::addReferentiel",
     *          "__api_resource_class"=Referentiel::class,
     *          "__api_collection_operation_name"="referentiel"
     *     }
     *
     *
     *  )
     */
    public function addReferentiel(Request $request, EntityManagerInterface $manager, GroupeCompetenceRepository $groupeCompRepo)
    {
      
        $requRef = $request->request->all();
        $ref = new Referentiel();
        $ref->setLibelle($requRef['libelle']);
        $ref->setPresentation($requRef['presentation']);
        $ref->setCritereAdmission($requRef['critereAdmission']);
        $ref->setCritereEvaluation($requRef['critereEvaluation']);
        if ($request->files->get('programme')) {
            $programme = $request->files->get('programme');
            $programme = fopen($programme->getRealPath(), 'r+');
            $ref->setProgramme($programme);
        }
        if ($requRef['groupeCompetence']) {
            $tab = explode(',', $requRef['groupeCompetence']);
            for ($i=0; $i<count($tab)-1; $i++) {
                if ($groupeCompRepo->findOneBy(['id'=>(int)$tab[$i]])) {
                    $ref->addGroupeCompetence($groupeCompRepo->findOneBy(['id'=>(int)$tab[$i]]));
                }
            }
        }
        $manager->persist($ref);
        $manager->flush();
        return new JsonResponse("Referentiel ajouté avec succés", 200,[]);
    }




    /**
     * @Route(
     *      name="putRef",
     *      path="/api/admin/referentiels/{id}",
     *      defaults={
     *          "__controller"="App\Controller\ReferentielController::editeReferentiel",
     *          "__api_resource_class"=Referentiel::class,
     *          "__api_collection_operation_name"="referentiel"
     *     }
     *
     *
     *  )
     */
//     public function editeReferentiel(Request $request, $id, ReferentielRepository $ref, GroupeCompetenceRepository $groupeCompetenceRepository,
//             EntityManagerInterface $manager, ServicePhoto $servicePhoto
//     ){
//
//
//         $refUpdate = $servicePhoto->gererPhoto($request, 'programme');
//         unset($refUpdate['programme']);
//         $refRepo = $ref->find($id);
//         foreach($refRepo->getGroupeCompetence() as $key => $value){
//             $refRepo->removeGroupeCompetence($value);
//         }
//         //dd($refRepo);
//         foreach($refUpdate as $key => $value){
//             //$setter = 'set'. ucfirst(strtolower($key));
//             if($key == "groupeCompetence"){
//                 $tab = explode(',', $value);
//                 for($i=0; $i<count($tab)-1; $i++){
//                     if($groupeCompetenceRepository->findOneBy(['id' => (int)$tab[$i]])){
//                         $refRepo->addGroupeCompetence($groupeCompetenceRepository->findOneBy(['id' => (int)$tab[$i]]));
//                     }
//                 }
//             }
//             // if(method_exists(Referenciel::class, $setter)){
//
//             //         $refRepo->$setter($value);
//             //   }
//
//         }
//         //dd($refRepo);
//         $manager->persist($refRepo);
//         //dd($manager);
//         $manager->flush();
//         return new JsonResponse("success",200,[],true);
//     }
  
}
