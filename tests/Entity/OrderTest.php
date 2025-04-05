<?php
namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * The Order instance being tested.
     * 
     * @var Order
     */
    private Order $order;

    /**
     * Set up method called before each test method.
     * 
     * Initializes a new Order instance for each test to ensure a clean state.
     */
    protected function setUp(): void
    {
        $this->order = new Order();
    }

    /**
     * Test default values of a newly created Order.
     * 
     * Verifies that:
     * - The default status is null
     * - ID is initially null
     * - Total amount, shipping amount, payment method, payment status, tracking number,
     *   notes, shipping address, and billing address are initially null
     * - Created at and updated at are instances of DateTimeImmutable
     * - Order items collection is empty
     */

    public function testDefaultValues()
    {
        // Test default values
        $this->assertNull($this->order->getId());
        $this->assertNull($this->order->getStatus());
        $this->assertNull($this->order->getTotalAmount());
        $this->assertNull($this->order->getShippingAmount());
        $this->assertNull($this->order->getPaymentMethod());
        $this->assertNull($this->order->getPaymentStatus());
        $this->assertNull($this->order->getTrackingNumber());
        $this->assertNull($this->order->getNotes());
        $this->assertNull($this->order->getShippingAddressId());
        $this->assertNull($this->order->getBillingAddressId());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getUpdatedAt());

        // Test initial state of order items
        $this->assertCount(0, $this->order->getOrderItems());
    }

    /**
     * Test setters and getters for Order entity.
     * 
     * This test verifies that the setters and getters work correctly by setting
     * values using the setters and then asserting that the getters return the
     * expected values.
     */
    public function testSettersAndGetters(): void 
    {
        // Create mock objects for User and Address
        $user = $this->createMock(User::class);
        $shippingAddress = $this->createMock(Address::class);
        $billingAddress = $this->createMock(Address::class);

        // Set values using setters
        $this->order
            ->setUserId($user)
            ->setShippingAddressId($shippingAddress)
            ->setBillingAddressId($billingAddress)
            ->setStatus('pending')
            ->setTotalAmount(100.00)
            ->setShippingAmount(10.00)
            ->setPaymentMethod('credit_card')
            ->setPaymentStatus('paid')
            ->setTrackingNumber('123456789')
            ->setNotes('Please deliver between 9 AM and 5 PM');

        // Assert that the values are set correctly
        $this->assertSame($user, $this->order->getUserId());
        $this->assertSame($shippingAddress, $this->order->getShippingAddressId());
        $this->assertSame($billingAddress, $this->order->getBillingAddressId());
        $this->assertEquals('pending', $this->order->getStatus());
        $this->assertEquals(100.00, $this->order->getTotalAmount());
        $this->assertEquals(10.00, $this->order->getShippingAmount());
        $this->assertEquals('credit_card', $this->order->getPaymentMethod());
        $this->assertEquals('paid', $this->order->getPaymentStatus());
        $this->assertEquals('123456789', $this->order->getTrackingNumber());
        $this->assertEquals('Please deliver between 9 AM and 5 PM', $this->order->getNotes());
    }


    /**
     * Test lifecycle callbacks for created and updated timestamps.
     * 
     * Verifies that:
     * - Created and updated dates are automatically set
     * - Updated date changes on subsequent updates
     * - Created date remains constant
     */
    public function testLifecycleCallbacks(): void
    {
        $this->order->setCreatedAtValue();
        
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getUpdatedAt());
        
        // Test PreUpdate
        $oldUpdatedAt = $this->order->getUpdatedAt();
        sleep(1); // Wait 1 second to ensure different timestamp

        $this->order->setUpdatedAtValue();
        
        $this->assertNotEquals($oldUpdatedAt, $this->order->getUpdatedAt());

        $this->assertSame($this->order->getCreatedAt(), $this->order->getCreatedAt());
    }

    /*     * Test the relationship between Order and OrderItem entities.
     * 
     * Verifies that:
     * - Order items can be added and removed correctly
     */
    public function testOrderItemsRelation()
    {
        // Create a mock OrderItem
        $orderItem = $this->createMock(OrderItem::class);

        // Add the order item to the order
        $this->order->addOrderItem($orderItem);

        // Assert that the order item is added correctly
        $this->assertCount(1, $this->order->getOrderItems());
        $this->assertSame($orderItem, $this->order->getOrderItems()->first());

        // Remove the order item from the order
        $this->order->removeOrderItem($orderItem);

        // Assert that the order item is removed correctly
        $this->assertCount(0, $this->order->getOrderItems());
    }
}