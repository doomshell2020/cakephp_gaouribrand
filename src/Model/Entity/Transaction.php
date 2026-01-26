<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $type
 * @property int|null $payment_id
 * @property string|null $razorpay_order_id
 * @property string|null $razorpay_signature
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Appointment $appointment
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\RazorpayOrder $razorpay_order
 */
class Transaction extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'appointment_id' => true,
        'type' => true,
        'payment_id' => true,
        'razorpay_order_id' => true,
        'razorpay_signature' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'appointment' => true,
        'payment' => true,
        'razorpay_order' => true,
    ];
}
