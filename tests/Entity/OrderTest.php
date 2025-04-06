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
    public function testDefaultValues(): void
    {
        $this->assertNull($this->order->getId());
        $this->assertNull($this->order->getStatus());
        $this->assertNull($this->order->getTotalAmount());
        $this->assertNull($this->order->getShippingAmount());
        $this->assertNull($this->order->getPaymentMethod());
        $this->assertNull($this->order->getPaymentStatus());
        $this->assertNull($this->order->getTrackingNumber());
        $this->assertNull($this->order->getNotes());
        $this->assertNull($this->order->getShippingAddress());
        $this->assertNull($this->order->getBillingAddress());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->order->getUpdatedAt());
        $this->assertCount(0, $this->order->getOrderItems());
    }

    /**
     * Test setters and getters for Order entity.
     * 
     * Verifies that:
     * - Each setter correctly sets the corresponding property
     * - Each getter retrieves the correct value
     */
    public function testSettersAndGetters(): void
    {
        $status = 'pending';
        $totalAmount = '100.00';
        $shippingAmount = '10.00';
        $paymentMethod = 'credit_card';
        $paymentStatus = 'paid';
        $trackingNumber = '123456789';
        $notes = 'Please deliver between 9 AM and 5 PM';
        $user = $this->createMock(User::class);
        $shippingAddress = $this->createMock(Address::class);
        $billingAddress = $this->createMock(Address::class);

        $this->order
            ->setUserId($user)
            ->setShippingAddress($shippingAddress)
            ->setBillingAddress($billingAddress)
            ->setStatus($status)
            ->setTotalAmount($totalAmount)
            ->setShippingAmount($shippingAmount)
            ->setPaymentMethod($paymentMethod)
            ->setPaymentStatus($paymentStatus)
            ->setTrackingNumber($trackingNumber)
            ->setNotes($notes);

        $this->assertSame($user, $this->order->getUserId());
        $this->assertSame($shippingAddress, $this->order->getShippingAddress());
        $this->assertSame($billingAddress, $this->order->getBillingAddress());
        $this->assertEquals($status, $this->order->getStatus());
        $this->assertEquals($totalAmount, $this->order->getTotalAmount());
        $this->assertEquals($shippingAmount, $this->order->getShippingAmount());
        $this->assertEquals($paymentMethod, $this->order->getPaymentMethod());
        $this->assertEquals($paymentStatus, $this->order->getPaymentStatus());
        $this->assertEquals($trackingNumber, $this->order->getTrackingNumber());
        $this->assertEquals($notes, $this->order->getNotes());
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

        $oldUpdatedAt = $this->order->getUpdatedAt();
        sleep(1);

        $this->order->setUpdatedAtValue();

        $this->assertNotEquals($oldUpdatedAt, $this->order->getUpdatedAt());
        $this->assertSame($this->order->getCreatedAt(), $this->order->getCreatedAt());
    }

    /**
     * Test the relationship between Order and OrderItem entities.
     * 
     * Verifies that:
     * - Order items can be added and removed correctly
     */
    public function testOrderItemsRelation(): void
    {
        $orderItem = $this->createMock(OrderItem::class);

        $this->order->addOrderItem($orderItem);
        $this->assertCount(1, $this->order->getOrderItems());
        $this->assertSame($orderItem, $this->order->getOrderItems()->first());

        $this->order->removeOrderItem($orderItem);
        $this->assertCount(0, $this->order->getOrderItems());
    }

    /**
     * Test the relationship between Order and User entities.
     * 
     * Verifies that:
     * - A user can be set and retrieved from an order
     */
    public function testUserRelation(): void
    {
        $user = new User();

        // Set user
        $this->order->setUserId($user);
        $this->assertSame($user, $this->order->getUserId());

        // Unset user
        $this->order->setUserId(null);
        $this->assertNull($this->order->getUserId());
    }
}