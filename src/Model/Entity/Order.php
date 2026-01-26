<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $total_amount
 * @property int|null $total_gst
 * @property int|null $quantity
 * @property int|null $total_weight
 * @property int|null $total_freight
 * @property \Cake\I18n\FrozenTime $order_date
 * @property string $order_status
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class Order extends Entity
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
    // protected $_accessible = [
    //     'user_id' => true,
    //     'total_amount' => true,
    //     'total_gst' => true,
    //     'quantity' => true,
    //     'total_weight' => true,
    //     'total_freight' => true,
    //     'order_date' => true,
    //     'order_status' => true,
    //     'user' => true,
    //     'order_details' => true,
    //     'product_amnt' => true,
    //     'total_gst_amnt' => true,
    //     'state_id' => true,
    //     'billng_address' => true,
    // ];
}
