<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create sample users
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com")
                ->setPassword('password') 
                ->setFirstName("FirstName$i")
                ->setLastName("LastName$i")
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($user);

            // Create sample addresses for each user
            for ($j = 1; $j <= 2; $j++) {
                $address = new Address();
                $address->setType('billing')
                    ->setFirstName("FirstName$j")
                    ->setLastName("LastName$j")
                    ->setStreet1("123 Street $j")
                    ->setCity("City$j")
                    ->setCountry("US")
                    ->setZipCode("12345")
                    ->setIsDefault(true)
                    ->setUser($user)
                    ->setCreatedAtValue();
                $manager->persist($address);
            }
        }

        // Create sample products
        for ($i = 1; $i <= 5; $i++) {
            $product = new Product();
            $product->setName("Product $i")
                ->setPrice((string)(10.99 * $i))
                ->setStock(100 * $i)
                ->setType('type-' . $i)
                ->setSlug("product-$i")
                ->setDescription("Description for Product $i")
                ->setStatus('active');
            $manager->persist($product);

            // Create sample orders and order items
            $order = new Order();
            $order->setStatus('pending')
                ->setTotalAmount((string)(50.99 * $i))
                ->setShippingAmount((string)(5.99))
                ->setPaymentMethod('credit_card')
                ->setPaymentStatus('paid')
                ->setShippingAddress($address)
                ->setBillingAddress($address)  
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($order);

            $orderItem = new OrderItem();
            $orderItem->setOrder($order)
                ->setProduct($product)
                ->setQuantity($i)
                ->setUnitPrice((string)(10.99 * $i));
            $manager->persist($orderItem);
        }

        $manager->flush();
    }
}
