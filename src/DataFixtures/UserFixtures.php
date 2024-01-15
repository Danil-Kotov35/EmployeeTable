<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user -> setEmail('patron@email.com');
        $user -> setPassword('$2y$13$hxnA1RQbRcg1kMj6FDji0eMhSZuxgaGlWVQpW51MyWylaEZOaUBPi');
        $user -> setRoles(['ROLE_USER']);

        $manager -> persist($user);
        $manager->flush();
    }
}
