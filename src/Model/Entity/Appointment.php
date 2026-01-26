<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appointment Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $store_id
 * @property \Cake\I18n\FrozenDate $appointment_date
 * @property int $slot_id
 * @property int $amount
 * @property string $status
 * @property string $payment_status
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\Slot $slot
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Appointment extends Entity
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
        'user_id' => true,
        'store_id' => true,
        'appointment_date' => true,
        'slot_id' => true,
        'amount' => true,
        'status' => true,
        'payment_status' => true,
        'modified' => true,
        'user' => true,
        'store' => true,
        'slot' => true,
        'transactions' => true,
    ];
}
