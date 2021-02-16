<?php


namespace App\Services;

use App\Entity\Referentiel;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;



class MyservicesPdf {

    private $targetDirectory;
    private $sluger;


    public function __construct(ReferentielRepository $repo, SluggerInterface $sluger)
    {
        $this->referentielrepository = $repo;
        $this->sluger = $sluger;
    }

    public function uploadPdf(UploadedFile $file){
        $orginalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->sluger->slug($orginalFileName);
        $fileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

        try{
            $file->move($this->referentielrepositorye->getProgramme(), $fileName);
        }catch(FileException $e){
            //////////////////////////
        }
        return $fileName;
    }


}