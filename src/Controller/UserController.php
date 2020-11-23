<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Cm;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * UserController constructor.
     */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }


    /**
     * * @Route(
     *      name="adding",
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
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     */
    public function addUser(Request $request,SerializerInterface $serializer, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {

        $user =$request->request->all();
        dd($user['type']);
        $avatar=$request->files->get("photo");
        $avatar=fopen($avatar->getRealPath(),"r+");
        if($user['type'] == "ADMIN"){
            $data =  $serializer->denormalize($user,Admin::class);
            $data->setPhoto($avatar);
            $pass = 'pass12345';
            $data->setPassword($encoder->encodePassword($data,$pass));
            //$user->setPassword($password);
            $manager->persist($data);
        }elseif ($user['type'] == "CM"){
            $data =  $serializer->denormalize($user,Cm::class);
            $data->setPhoto($avatar);
            $pass = 'pass12345';
            $data->setPassword($encoder->encodePassword($data,$pass));
            //$user->setPassword($password);

            $manager->persist($data);
        }



        $manager->flush();

        return $this->json("success");

    }



}
