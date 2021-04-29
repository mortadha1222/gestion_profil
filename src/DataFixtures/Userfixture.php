<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Userfixture extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
      //  $this->createMany(10, 'main_users', function($i) {
    $user = new User();
    //$user->setUsername(sprintf('username', $i));
    //$user->setFirstName($this->faker->firstName);
    $user->setPassword($this->passwordEncoder->encodePassword(
        $user,
        'engage'
    ));
    return $user;

        $manager->flush();
    }
}
