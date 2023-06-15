<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUserId('1');
        $user->setUserName('Alice');
        $user->setPassword('***');
        $manager->persist($user);

        $category = new Category();
        $category->setCategoryId('1');
        $category->setName('Personnal');
        $manager->flush();

        $note = new Note();
        $note->setNoteId('1');
        $note->setTitle('Note 1');
        $note->setContent('Lorem ipsum dolor sit amet');
    }
}
