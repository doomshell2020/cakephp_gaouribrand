<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property int $id
 * @property string $code
 * @property string $applicable_to
 * @property string $applicable_type
 * @property string $discount_type
 * @property float $minimum_order_value
 * @property float $maximum_discount
 * @property float $discount_rate
 * @property \Cake\I18n\FrozenTime $valid_from
 * @property \Cake\I18n\FrozenTime $valid_to
 * @property string|null $max_redeem_type
 * @property float|null $max_redeem_rate
 * @property string $description
 * @property \Cake\I18n\FrozenTime|null $cashback_expiry_date
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CouponsProduct[] $coupons_products
 * @property \App\Model\Entity\Category[] $categories
 */
class Coupon extends Entity
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
    //     'code' => true,
    //     'applicable_to' => true,
    //     'applicable_type' => true,
    //     'discount_type' => true,
    //     'minimum_order_value' => true,
    //     'maximum_discount' => true,
    //     'discount_rate' => true,
    //     'valid_from' => true,
    //     'valid_to' => true,
    //     'max_redeem_type' => true,
    //     'max_redeem_rate' => true,
    //     'description' => true,
    //     'cashback_expiry_date' => true,
    //     'status' => true,
    //     'created' => true,
    //     'modified' => true,
    //     'coupons_products' => true,
    //     'categories' => true,
    // ];
}
