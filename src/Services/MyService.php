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
   /* private $serializer;

    public function _files($request)
    {
        global $avatar;
        $avatar= $request->files->get("avatar");
        if($avatar){
            $avatar = fopen($avatar->getRealPath(), "rb");
            return $avatar;
        }
        return null;
    }

    public function formBinary($request){

        $user = $request->getContent();
        $boundary = str_replace("multipart/form-data; boundary=","",$request->headers->get('Content-Type'));
        $delimit = [$boundary," ","--","\n",'"',"Content-Disposition:","form-data;","name="];
        $tab = str_replace($delimit,"",$user);
        $explo = explode("\r\r", $tab);
        $datas = [];

        for($i = 0; isset($explo[$i+1]); $i+=2){
            $d = str_replace(["\r"],"",$explo[$i]);
            if( strstr($d,"avatar"))
            {
                $d = "avatar";
                $stream = fopen("php://memory","r+");
                fwrite($stream, $explo[$i+1]);
                rewind($stream);
                $datas[$d] = $stream;
            }
            else
            {
                $datas[$d] = $explo[$i+1];
            }
        }
        return $datas;
    }


    //add or update user
    public function newUser($request,$serializer,$validator, $entity,$manager,$encoder)
    {
        $user = $request->request->all();
        if(!$user)$user = json_decode($request->getContent(), true);

        $user["avatar"] = $this->_files($request);
        $user = $serializer->denormalize($user, $entity);
        $errors = $validator->validate($user);
        // dd($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $password = "pass_1234";
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setArchive(true);

        $user = $this->flushUser($manager,$user);
        dd($user);
        return $user;
    }

    //update user
    public function updateUser($request, $userepository,$profilrepository,$manager,$encoder)
    {
        $user= $userepository->findOneBy(["id"=>$request->attributes->get('id')]);
        dd($user);
        $datas =  $this->formBinary($request);
        $user = $this->setterDynamic($datas,$user,$profilrepository,$encoder);
        $user = $this->flushUser($manager,$user);
        return $user;
    }
    // setter dynamique
    public function setterDynamic($data,$users,$profilripo,$encoder){
        if(is_array($data)|| is_object($data)) {
            foreach ($data as $key => $value) {
                $setter = 'set'.ucfirst(strtolower($key));
                if (method_exists($users, $setter)) {
                    if ($key=='profil') {
                        $profil = $data['profil'];
                        $profil = $profilripo->findOneBy(['id' => $profil]);
                        // dd($profile->getLibelle());
                        $users->$setter($profil);
                    }elseif($key=='password')
                    {
                        $users->$setter($encoder->encodePassword($users, $data['password']));
                    }
                    else {
                        $users->$setter($value);
                    }
                }
            }

        }
        return $users;
    }


    //function persister and fush object
    public function flushUser($manager,$user)
    {
        $manager->persist($user);
        $manager->flush();
        global $avatar;
        if($avatar) fclose($avatar);
        return $user;
    }
*/
    public function uploadImage($request)
    {


        $uploadedFile = $request->files->get('photo');
        $file = $uploadedFile->getRealPath();
        $avartar = fopen($file,'r+');
        $userReq['photo'] = $avartar;
        return $uploadedFile;
    }

}
