<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * password encoder
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_Fr');

        for ($u=0; $u < 20; $u++) {
            $user = new User();
            $user
                ->setName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, "password"));

            $manager->persist($user);

            for ($a=0; $a < mt_rand(1, 10); $a++) {
                $article = new Article();
                $article
                    ->setTitle($faker->sentence($nbWords = mt_rand(6, 15), $variableNbWords = true))
                    ->setContent($faker->realText($maxNbChars = mt_rand(100, 400), $indexSize = 2))
                    ->setAuthor($user)
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                $manager->persist($article);

                for ($c=0; $c < mt_rand(10, 30); $c++) {
                    $comment = new Comment();
                    $comment
                        ->setContent($faker->sentence($nbWords = mt_rand(1, 8), $variableNbWords = true))
                        ->setAuthor($user)
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setArticle($article);

                    $manager->persist($comment);
                }
            }

        }

        $manager->flush();
    }
}
