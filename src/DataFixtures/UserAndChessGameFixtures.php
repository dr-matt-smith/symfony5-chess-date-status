<?php

namespace App\DataFixtures;

use App\Entity\ChessGame;
use App\Entity\GameResult;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserAndChessGameFixtures extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        // create User objects
        $userUser = $this->createUser('user@user.com', 'user');
        $userAdmin = $this->createUser('admin@admin.com', 'admin', 'ROLE_ADMIN');
        $userMatt = $this->createUser('matt.smith@smith.com', 'smith', 'ROLE_SUPER_ADMIN');

        // add to DB queue
        $manager->persist($userUser);
        $manager->persist($userAdmin);
        $manager->persist($userMatt);

        // create game results objects
        $results = [
            'White wins - CHECKMATE',
            'Black wins - CHECKMATE',
            'DRAW- agreed by players',
            'DRAW - STALEMATE',
            'White wins - Black RESIGNS',
            'Black wins - White RESIGNS'
        ];

        foreach($results as $resultString){
            $result = new GameResult();
            $result->setDescription($resultString);
            $manager->persist($result);
        }


        // create Chess Game objects

        // this one completed ....
        $game1 = new ChessGame();
        $game1->setPlayer1White($userAdmin);
        $game1->setPlayer2Black($userMatt);
        $game1->setCompleted(true);
        $game1->setStartDateTime(new \DateTime("2020-04-19"));
        $game1->setResult($result); // just use last result in array ...


        $game2 = new ChessGame();
        $game2->setPlayer1White($userMatt);
        $game2->setPlayer2Black($userAdmin);
        $game2->setCompleted(false);
        $game2->setStartDateTime(new \DateTime("2020-04-21"));

        $game3 = new ChessGame();
        $game3->setPlayer1White($userAdmin);
        $game3->setPlayer2Black($userUser);
        $game3->setCompleted(false);
        $game3->setStartDateTime(new \DateTime("2020-04-22"));

        // add to DB queue
        $manager->persist($game1);
        $manager->persist($game2);
        $manager->persist($game3);

        // send query to DB
        $manager->flush();

    }

    private function createUser($username, $plainPassword, $role = 'ROLE_USER'):User
    {
        $user = new User();
        $user->setEmail($username);
        $user->setRole($role);

        // password - and encoding
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        return $user;
    }
}