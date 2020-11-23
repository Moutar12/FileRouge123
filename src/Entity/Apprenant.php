<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "post":{
 *              "path":"/apprenants",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     }
 *  }
 * )
 */
class Apprenant extends User
{

}
