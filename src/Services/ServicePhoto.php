<?php


namespace App\Services;


use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

class ServicePhoto{

public function __construct(UserPasswordEncoderInterface $encoder, SerializerInterface $serialize,
            ProfilRepository $profil, ValidatorInterface $validator)
   {
    $this->encoder = $encoder;
    $this->serialize = $serialize;
    $this->profilrepository = $profil;
    $this->validator = $validator;
   }

   public function gererPhoto(Request $request, string $fileName = null ): array{
    $avartar = $request->getContent();
    $delimit = "multipart/form-data; boundary=";
    $boundary = "--".explode($delimit, $request->headers->get('content-type'))[1];
    $elements = str_replace([$boundary, 'content-dispostion: form-data;', "name="], "", $avartar);
    $elementsTab = explode("\r\n\r\n", $elements);
    $data = [];
   $elementsTab = explode("\r\n\r\n", $elements);
        //dd($elementsTab);
        $data = [];
        for ($i = 0; isset($elementsTab[$i + 1]); $i += 2) {
            //dd($elementsTab[$i+1]);
            $key = str_replace(["\r\n", ' "', '"'], '', $elementsTab[$i]);
            //dd($key);
            if (strchr($key, $fileName)) {
                $stream = fopen('php://memory', 'r+');
                //dd($stream);
                fwrite($stream, $elementsTab[$i + 1]);
                rewind($stream);
                $data[$fileName] = $stream;
                //dd($data);
            } else {
                $val = $elementsTab[$i + 1];
                $val = str_replace(["\r\n", "--"],'',$elementsTab[$i+1]);
                //dd($val);
                $data[$key] = $val;
                // dd($data[$key]);
            }
        }
    if (isset($data['profil'])) {
        $profils = $this->profilrepository->findOneBy(['libelle'=>$data["profil"]]);
        $data["profil"] = $profils;   
    }
    return $data;
   }


}
