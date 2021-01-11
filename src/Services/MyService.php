<?php


namespace App\Services;


use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Cm;
use App\Entity\Formateur;
use App\Entity\User;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

class MyService
{

//
//     public function uploadImage($request)
//     {
//
//
//         $uploadedFile = $request->files->get('photo');
//         $file = $uploadedFile->getRealPath();
//         $avartar = fopen($file,'r+');
//         $userReq['photo'] = $avartar;
//         return $uploadedFile;
//     }

    public function __construct( UserPasswordEncoderInterface $encoder,SerializerInterface $serializer, ProfilRepository $profilRepository)
       {
           $this->encoder =$encoder;
           $this->serializer = $serializer;
           $this->profilRepository = $profilRepository;
       }

       public function addNewUser($profil, Request $request){
        $users = $request->request->all();

        $uploadedFile = $request->files->get('photo');
        if($uploadedFile){
        $file = $uploadedFile->getRealPath();
        $photo = fopen($file, 'r+');
        $users['photo'] = $photo;
        }

        if($profil == "Admin"){
        $user = Admin::class;
        }elseif($profil == "Formateur"){
        $user = Formateur::class;
        }elseif($profil == "Cm"){
        $user = Cm::class;
        }elseif($profil == "Apprenant"){
        $user = Apprenant::class;
        }else{
        $user = User::class;
        }
        $newUser = $this->serializer->denormalize($users, $user);
        $newUser->setProfil($this->profilRepository->findOneBy(['libelle' => $profil]));
        $newUser->setStatut(true);
        $password="pass12345";
        $newUser->setPassword($this->encoder->encodePassword($newUser, $password));
        return $newUser;
       }

    public function type($type){
        if($type == "Admin" || $type == "Formateur" || $type == "Cm" || $type == "Apprenant"){
        return $type;
        }
    }
}
