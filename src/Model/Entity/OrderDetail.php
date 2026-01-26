<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDetail Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $quantity
 * @property int|null $cgst
 * @property int|null $sgst
 * @property int|null $igst
 * @property int|null $mrp
 * @property int|null $net_price
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Product $product
 */
class OrderDetail extends Entity
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
    //     'order_id' => true,
    //     'product_id' => true,
    //     'quantity' => true,
    //     'cgst' => true,
    //     'sgst' => true,
    //     'igst' => true,
    //     'mrp' => true,
    //     'net_price' => true,
    //     'created' => true,
    //     'user' => true,
    //     'order' => true,
    //     'product' => true,
    // ];
}
