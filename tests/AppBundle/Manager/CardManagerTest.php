<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Manager\CardManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Workflow\Workflow;

class CardManagerTest extends TestCase
{
//    public function testGenerateNumber()
//    {
//        $this->assertTrue(true);
//    }
//    public function testAddCard()
//    {
//        $card = new Card();
//        $card->setNumber(123456456);
//        $card->setStatus('in_store');
//
//        $employeeRepository = $this->createMock(ObjectRepository::class);
//        $employeeRepository->expects($this->any())
//            ->method('find')
//            ->willReturn($card);
//
//        $objectManager = $this->createMock(ObjectManager::class);
//        $objectManager->expects($this->any())
//            ->method('getRepository')
//            ->willReturn($employeeRepository);
//
//        $workflow = $this->createMock(Workflow::class);
//        $workflow->expects($this->any())
//            ->method('can')
//            ->willReturn(true);
//
//
//        $cardManager = new CardManager($objectManager, $workflow);
//
//
//        //Vérification qu'il y a un flush
//        $this->assertEquals(2100, $cardManager->addCard(1, 1234567897));
//    }

//    /**
//     * @dataProvider constructorBadArgumentsProvider
//     */
//    public function testAddCardFalse()
//    {
//        $this->expectException(\Exception::class);
//
//
//
//
//
//        // Mock repository
//        // Mock entitymanager
//
//        // Mock player
//        // Mock card
//    }


//    public function constructorBadArgumentsProvider()
//    {
//        return [
//            ['Carbone'],
//            [null]
//        ];
//    }

}