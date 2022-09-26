<?php

namespace App\DataFixtures;

use App\Entity\Societe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    protected function getDirectoryContent(string $directory): array
    {
        $finder = Finder::create()
            ->in($directory)
            ->depth(0)
            ->name(['*.jpeg', '*.svg', '*.jpg', '*.png'])
            ->sortByName();

        return iterator_to_array($finder, true);
    }


    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $table = [];
        foreach ($this->getDirectoryContent('public/upload') as $file)
        {
            $fileInfos = new SplFileInfo($file);
            $fileName = $fileInfos->getBasename();
            $table[] = $fileName;
        }

            $faker = Factory::create();

            /* Sociétés */

            $societes = [];

            for ($s = 0; $s < 8; $s++){
                $societe = new Societe();
                $societe
                    ->setName($faker->company)
                    ->setLogo($table[random_int(0, count($table) -1)])
                    ->setBackgroundLogo($faker->hexColor)
                    ->setCity($faker->city)
                    ->setLogin($faker->userName)
                    ->setRoles(['ROLE_SOCIETY'])
                    ->setWebsite($faker->url)
                    ->setFirstnameContact($faker->firstName)
                    ->setLastnameContact($faker->lastName)
                    ->setEmail($faker->email)
                    ->setPhoneContact($faker->e164PhoneNumber)
                    ->setPassword($this->passwordHasher->hashPassword($societe, 'Test1234'));

                $societes[] = $societe;

                $manager->persist($societe);
            }

            
            /* Administrateur */

            $admin = new Societe();
            $admin
                ->setName($faker->company)
                ->setLogo($table[random_int(0, count($table) -1)])
                ->setBackgroundLogo($faker->hexColor)
                ->setCity($faker->city)
                ->setLogin('Mathieu')
                ->setRoles(['ROLE_ADMIN'])
                ->setWebsite($faker->url)
                ->setFirstnameContact($faker->firstName)
                ->setLastnameContact($faker->lastName)
                ->setEmail($faker->email)
                ->setPhoneContact($faker->e164PhoneNumber)
                ->setPassword($this->passwordHasher->hashPassword($admin, 'Test1234'));

            $manager->persist($admin);




        $manager->flush();
    }
}
