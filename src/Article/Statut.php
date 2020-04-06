<?php

namespace App\Article;

class Statut
{
    const NONPUBLIE=0;
    const BROUILLON=1;
    const PUBLIE=2;


    public static function getStatut(): array {
        return [
            self::NONPUBLIE,
            self::BROUILLON,
            self::PUBLIE
        ];
    }
}