<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $shipping_amount = null;

    #[ORM\Column(length: 50)]
    private ?string $payment_method = null;

    #[ORM\Column(length: 50)]
    private ?string $payment_status = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tracking_number = null;

    #[ORM\Column(type:Types::TEXT)]
    private ?string $notes = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $shipping_address_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $billing_address_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->total_amount;
    }

    public function setTotalAmount(string $total_amount): static
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getShippingAmount(): ?string
    {
        return $this->shipping_amount;
    }

    public function setShippingAmount(string $shipping_amount): static
    {
        $this->shipping_amount = $shipping_amount;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): static
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(string $payment_status): static
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->tracking_number;
    }

    public function setTrackingNumber(?string $tracking_number): static
    {
        $this->tracking_number = $tracking_number;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getShippingAddressId(): ?int
    {
        return $this->shipping_address_id;
    }

    public function setShippingAddressId(int $shipping_address_id): static
    {
        $this->shipping_address_id = $shipping_address_id;

        return $this;
    }

    public function getBillingAddressId(): ?Address
    {
        return $this->billing_address_id;
    }

    public function setBillingAddressId(?Address $billing_address_id): static
    {
        $this->billing_address_id = $billing_address_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
