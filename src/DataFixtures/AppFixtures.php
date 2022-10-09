<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use App\Entity\Offres;
use App\Entity\Societe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Monolog\DateTimeImmutable;
use Symfony\Component\Finder\Finder;
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
            $fileInfos = new \SplFileInfo($file);
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


            /* Les offres */

            $offres = [];
            $o = array("CDI", "CDD", 'Alternance', "Stage");
            $comp = array("Autonomie", "Rigueur", 'Organisé', "Communication");

            for ($i = 0; $i < 20; $i++){
                $offre = new Offres();
                $offre
                    ->setTitle($faker->jobTitle)
                    ->setContratType($o[array_rand($o)])
                    ->setDescription($faker->realText())
                    ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')))
                    ->setProfilDesc($faker->realText())
                    ->setProfilComp($comp[array_rand($comp)])
                    ->setPosteDesc($faker->realText())
                    ->setPosteMission($faker->realText())
                    ->setSociete($societes[random_int(0, count($societes) -1)])
                    ->setWebsite($faker->url);

                $offres[] = $offre;

                $manager->persist($offre);

            }

            /* Les candidats */

            $candidats = [];

            for ($c = 0; $c < 80; $c++){
                $candidat = new Candidat();

                $candidat
                    ->setFirstname($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setPhone($faker->e164PhoneNumber)
                    ->setEmail($faker->email)
                    ->setCandidatCv('cv-candidat-perrot.pdf')
                    ->setOffre($offres[random_int(0, count($offres) -1)])
                    ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

                $candidats[] = $candidat;
                $manager->persist($candidat);


            }

        $manager->flush();
    }
}
