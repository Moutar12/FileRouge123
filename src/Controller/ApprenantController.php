<?php

namespace App\Controller;

use App\Datapersister\ProfilDataPersister;
use App\Entity\Apprenant;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\ProfilRepository;
use App\Services\MyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApprenantController extends AbstractController
{
    /**
     * UserController constructor.
     */
    private $encoder;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $Serializer;
    /**
     * @var ProfilRepository
     */
    private ProfilRepository $Repository;
    private $getlibelleProfil;
    private $profilRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, SerializerInterface $serializer,ProfilRepository $repository){
        $this->encoder = $encoder;
        $this->Serializer = $serializer;
        $this->Repository = $repository;
    }


    /**
     * * @Route(
     *      name="post_apprenant",
     *      path="/api/apprenants",
     *      defaults={
     *          "__controller"="App\Controller\UserController::addApprenant",
     *          "__api_resource_class"=Apprenant::class,
     *          "__api_collection_operation_name"="apprenants"
     *     }
     *
     *
     *  )
     * @param Request $request
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     *
     * @return JsonResponse
     */
    public function addApprenant(Request $request,SerializerInterface $serializer,ValidatorInterface $validate,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder, MyService $myServices)
    {
        $userReq = $request->request->all();
        //dd($userReq);
        $userReq = $serializer->denormalize($userReq, "App\Entity\Apprenant");
        //dd($userReq);
        $errors=$validate->validate($userReq);
        if(@count($errors))
        {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $password="passer12345";
        $userReq->setPassword($encoder->encodePassword($userReq,$password));
        $userReq->setStatut(0);
        //dd($myServices);
        $avatar= $myServices->uploadImage($request);

        $userReq->setPhoto($avatar);
        $manager->persist($userReq);
        $manager->flush();
        return $this->json("Apprenant ajouté",Response::HTTP_CREATED);

    }


}
