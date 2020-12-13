<?php

namespace App\Controller;

use App\Entity\Formateur;
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

class FormateurController extends AbstractController
{


    /**
     * * @Route(
     *      name="post_formateur",
     *      path="/api/formateurs",
     *      defaults={
     *          "__controller"="App\Controller\UserController::addApprenant",
     *          "__api_resource_class"=Formateur::class,
     *          "__api_collection_operation_name"="formateurs"
     *     }
     *
     *
     *  )
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validate
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param MyService $myServices
     * @return JsonResponse
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */

public function addFormateur(Request $request,SerializerInterface $serializer,ValidatorInterface $validate,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder, MyService $myServices)
{
    $userReq = $request->request->all();
    //dd($userReq);
    $userReq = $serializer->denormalize($userReq, "App\Entity\Formateur");
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
    return $this->json("Formateur ajouté",Response::HTTP_CREATED);

}

}
