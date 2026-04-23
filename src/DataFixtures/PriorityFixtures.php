<?php

namespace App\DataFixtures;

use App\Entity\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PriorityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Priorité 1 : Urgent (rouge)
        $urgent = new Priority();
        $urgent->setName('Urgent');
        $urgent->setImportance(1);
        $urgent->setColor('#EF4444');
        $urgent->setUser(null); // Priorité par défaut disponible pour tous
        $manager->persist($urgent);

        // Priorité 2 : Important (orange)
        $important = new Priority();
        $important->setName('Important');
        $important->setImportance(2);
        $important->setColor('#F97316');
        $important->setUser(null);
        $manager->persist($important);

        // Priorité 3 : Normal (bleu)
        $normal = new Priority();
        $normal->setName('Normal');
        $normal->setImportance(3);
        $normal->setColor('#3B82F6');
        $normal->setUser(null);
        $manager->persist($normal);

        $manager->flush();
    }
}
