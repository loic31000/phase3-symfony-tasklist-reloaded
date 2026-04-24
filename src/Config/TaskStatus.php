<?php

namespace App\Config;

enum TaskStatus: string
{
    case EN_COURS = 'en_cours';
    case TERMINEE = 'terminee';
    case ARCHIVEE = 'archivee';
    
    /**
     * Retourne l'ordre de priorité pour le tri (plus petit = plus haut dans la liste)
     */
    public function getOrder(): int
    {
        return match($this) {
            self::EN_COURS => 1,
            self::TERMINEE => 2,
            self::ARCHIVEE => 3,
        };
    }
    
    /**
     * Retourne le label en français
     */
    public function getLabel(): string
    {
        return match($this) {
            self::EN_COURS => 'En cours',
            self::TERMINEE => 'Terminée',
            self::ARCHIVEE => 'Archivée',
        };
    }
}