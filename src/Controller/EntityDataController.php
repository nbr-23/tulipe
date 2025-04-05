<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EntityDataController extends AbstractController
{
    #[Route('/entities/data', name: 'entities_data', methods: ['GET'])]
    public function getAllEntitiesData(EntityManagerInterface $entityManager): JsonResponse
    {
        // Fetch all entities
        $orders = $entityManager->getRepository(Order::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();
        $addresses = $entityManager->getRepository(Address::class)->findAll();
        $orderItems = $entityManager->getRepository(OrderItem::class)->findAll();

        // Serialize data
        $data = [
            'orders' => $orders,
            'users' => $users,
            'addresses' => $addresses,
            'orderItems' => $orderItems,
        ];

        // Return serialized JSON response
        return $this->json($data, 200, [], ['groups' => ['default']]);
    }
}
