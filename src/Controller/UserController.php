<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Cm;
use App\Entity\Formateur;
use App\Entity\Profil;
use App\Entity\User;
use App\Services\MyService;
use App\Services\ServicePhoto;
use App\Services\ServiceEmail;
use App\Services\PostValidator;
use Doctrine\ORM\EntityManager;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     */
    public function __construct(ProfilRepository $profilRepository,EntityManagerInterface $manager
            ,SerializerInterface $serializer,ServiceEmail $sendEmail,
              UserPasswordEncoderInterface $encode)
        {
            $this->manager = $manager;
            $this->serializer = $serializer;
            $this->MyserviceEmail = $sendEmail;
            $this->encode =$encode;
            $this->profilRepository =$profilRepository;
            //$this->validator =$validator;
        }


    /**
     * * @Route(
     *      name="adding",
     *     methods={"POST"},
     *      path="/api/admin/users",
     *      defaults={
     *          "__controller"="App\Controller\UserController::addUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="post_admin"
     *     }
     *
     *
     *  )
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validate
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param MyService $myServices
     * @param SerializerInterface $normalize
     * @return JsonResponse
     *
     */
//     public function addFormateur(Request $request,SerializerInterface $serializer,ValidatorInterface $validate,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder, MyService $myServices,SerializerInterface $normalize)
//     {
//         $userReq = $request->request->all();
//          //dd($userReq);
//
//         $userReq = $serializer->denormalize($userReq, "App\Entity\User");
//         //dd($userReq);
//         $errors=$validate->validate($userReq);
//         if(@count($errors))
//         {
//             $errors = $serializer->serialize($errors, "json");
//             return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
//         }
//         $password="passer12345";
//         $userReq->setPassword($encoder->encodePassword($userReq,$password));
//         $userReq->setStatut(0);
//
//         //dd($myServices);
//         $avatar= $myServices->uploadImage($request);
//
//         $userReq->setPhoto($avatar);
//         $manager->persist($userReq);
//         $manager->flush();
//         return $this->json("User ajoute",Response::HTTP_CREATED);
//
//     }


public function addUser(MyService $myServices, Request $request)
{
        $type = $request->get('type');
        $utili = $myServices->addNewUser($type, $request);
        //$this->validator->validatePost($utili);

        $utili->setStatut(false);
        $this->manager->persist($utili);
        $this->manager->flush();
        //$this->MyserviceEmail->send($utili->getEmail(), "User ajouté", 'Avec succes');

        return $this->json("User ajoute",Response::HTTP_CREATED);
}

        /**
             * @Route(
             *     "api/admin/users/{id}",
             *      name="putUserId",
             *     methods={"PUT"},
             *     defaults={
             *      "_api_resource_class"=User::class,
             *      "_api_item_operation_name"="putUserId"
             *     }
             *     )
             */
  public function updateUser(ServicePhoto $myServices, Request $request){
                $profil = $request->get('profil');
                $updateUser = $myServices->gererPhoto($request, 'photo');
                $utili = $request->attributes->get('data');
                foreach($updateUser as $key => $val){
                $setter = 'set'.ucfirst(strtolower($key));
                if(method_exists(User::class, $setter)){
                if($setter == 'setProfil'){
                $utili->setProfil($updateUser['profil']);
                }else{
                $utili->$setter($val);
                }
                if($setter == 'setPassword'){
                $utili->setPassword($this->encoder->encodePassword($utili, $updateUser['password']));
                }
                }
                $this->manager->persist($utili);
                $this->manager->flush();
                return new JsonResponse("Success", 200, [], true);                }
             }
}
