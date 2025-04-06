<?php

namespace App\Tests\Entity;

use App\Entity\OrderItem;
use App\Entity\Order;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    /**
     * The OrderItem instance being tested.
     * 
     * @var OrderItem
     */
    private OrderItem $orderItem;

    /**
     * Set up method called before each test method.
     * 
     * Initializes a new OrderItem instance for each test to ensure a clean state.
     */
    protected function setUp(): void
    {
        $this->orderItem = new OrderItem();
    }

    /**
     * Test default values of a newly created OrderItem.
     * 
     * Verifies that:
     * - ID is initially null
     * - Product is initially null
     * - Unit price is initially null
     * - Quantity defaults to 1
     * - Order is initially null
     */
    public function testDefaultValues(): void
    {
        $this->assertNull($this->orderItem->getId());
        $this->assertNull($this->orderItem->getProduct());
        $this->assertNull($this->orderItem->getUnitPrice());
        $this->assertSame(1, $this->orderItem->getQuantity());
        $this->assertNull($this->orderItem->getOrder());
    }

    /**
     * Test setters and getters for OrderItem entity.
     * 
     * Verifies that:
     * - Each setter correctly sets the corresponding property
     * - Each getter retrieves the correct value
     */
    public function testSettersAndGetters(): void
    {
        $product = $this->createMock(Product::class);
        $order = $this->createMock(Order::class);
        $unitPrice = '50.99';
        $quantity = 2;

        $this->orderItem
            ->setProduct($product)
            ->setUnitPrice($unitPrice)
            ->setQuantity($quantity)
            ->setOrder($order);

        $this->assertSame($product, $this->orderItem->getProduct());
        $this->assertEquals($unitPrice, $this->orderItem->getUnitPrice());
        $this->assertEquals($quantity, $this->orderItem->getQuantity());
        $this->assertSame($order, $this->orderItem->getOrder());
    }

    /**
     * Test the relationship between OrderItem and Product entities.
     * 
     * Verifies that:
     * - A product can be set and retrieved from an order item
     */
    public function testProductRelation(): void
    {
        $product = new Product();

        // Set product
        $this->orderItem->setProduct($product);
        $this->assertSame($product, $this->orderItem->getProduct());

        // Unset product
        $this->orderItem->setProduct(null);
        $this->assertNull($this->orderItem->getProduct());
    }

    /**
     * Test the relationship between OrderItem and Order entities.
     * 
     * Verifies that:
     * - An order can be set and retrieved from an order item
     */
    public function testOrderRelation(): void
    {
        $order = new Order();

        // Set order
        $this->orderItem->setOrder($order);
        $this->assertSame($order, $this->orderItem->getOrder());

        // Unset order
        $this->orderItem->setOrder(null);
        $this->assertNull($this->orderItem->getOrder());
    }
}
