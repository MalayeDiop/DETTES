<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ClientSearchDto {
    // #[Assert\Regex(
    //     pattern: '/^(77|76|78|70)([0-9]{7})$/',
    //     message : 'Veuillez saisir un numéro valable',
    // )]
    public string $telephone;
    public string $prenom;
}