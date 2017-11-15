<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Service\CardManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Workflow\Workflow;

class CardManagerTest extends TestCase
{
    public function testGenerateNumber()
    {
        $this->assertTrue(true);
    }
    public function testAddCard()
    {
        $card = new Card();
        $card->setNumber(123456456);
        $card->setStatus('in_store');

        $employeeRepository = $this->createMock(ObjectRepository::class);
        $employeeRepository->expects($this->any())
            ->method('find')
            ->willReturn($card);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($employeeRepository);

        $workflow = $this->createMock(Workflow::class);

        $cardManager = new CardManager($objectManager, $workflow);

        $this->assertEquals(2100, $cardManager->addCard(1, 1234567897));
    }
    public function testAddCardFalse()
    {

        // Mock repository
        // Mock entitymanager

        // Mock player
        // Mock card
    }
}