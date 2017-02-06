<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Users;
use AppBundle\Entity\Categories;
use AppBundle\Entity\Products;

class LoadUserData implements FixtureInterface {

    private $now;

    public function __construct() {
        $this->now = new \DateTime('now');
    }

    public function load(ObjectManager $manager) {
        $userAdmin = new Users();
        $userAdmin->setFirstname('Bobby')
                ->setLastname('Fischer')
                ->setEmail('bobby@foo.com')
                ->setUsername('bfischer')
                ->setPassword('Just4Now')
                ->setIsActive(true)
                ->setDatecreated($this->now)
                ->setDatemodifed($this->now);

        $manager->persist($userAdmin);
        $manager->flush();

        $userAdmin = new Users();
        $userAdmin->setFirstname('Betty')
                ->setLastname('Rubble')
                ->setEmail('betty@foo.com')
                ->setUsername('brubble')
                ->setPassword('Just4Now')
                ->setIsActive(true)
                ->setDatecreated($this->now)
                ->setDatemodifed($this->now);

        $manager->persist($userAdmin);
        $manager->flush();

        $categoryData = $this->loadCategoryData($manager, $userAdmin);
        $this->loadProductData($manager, $userAdmin, $categoryData);
    }

    public function loadCategoryData(ObjectManager $manager, $user) {
        $this->now = new \DateTime('now');

        $dataGames = new Categories();
        $dataGames->setTitle('Games')
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($dataGames);
        $manager->flush();

        $dataComputers = new Categories();
        $dataComputers->setTitle('Computers')
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($dataComputers);
        $manager->flush();

        $dataTv= new Categories();
        $dataTv->setTitle('TVs and Accessories')
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($dataTv);
        $manager->flush();
        return [$dataGames, $dataComputers, $dataTv];
    }

    public function loadProductData(ObjectManager $manager, $user, $categires) {

        $data = new Products();
        $data->setName('Pong')
                ->setCategoryid($categires[0])
                ->setSku('A0001')
                ->setPrice(69.99)
                ->setQuantity(20)
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($data);
        $manager->flush();

        $data = new Products();
        $data->setName('GameStation 5')
                ->setCategoryid($categires[0])
                ->setSku('A0002')
                ->setPrice(269.99)
                ->setQuantity(15)
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($data);
        $manager->flush();

        $data = new Products();
        $data->setName('AP Oman PC - Aluminum')
                ->setCategoryid($categires[1])
                ->setSku('A0003')
                ->setPrice(1399.99)
                ->setQuantity(10)
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($data);
        $manager->flush();

        $data = new Products();
        $data->setName("Fony UHD HDR 55\" 4k TV")
                ->setCategoryid($categires[2])
                ->setSku('A0004')
                ->setPrice(1399.99)
                ->setQuantity(5)
                ->setDatecreated($this->now)
                ->setDatemodified($this->now)
                ->setCreatedby($user)
                ->setModifiedby($user);
        $manager->persist($data);
        $manager->flush();

    }
}
