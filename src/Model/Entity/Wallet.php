<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Wallet Entity
 *
 * @property int $id
 * @property string $transaction_id
 * @property int $wallet_id
 * @property int $order_id
 * @property int $user_id
 * @property float $amount
 * @property bool $is_expiry
 * @property \Cake\I18n\FrozenTime|null $expiry_date
 * @property string $amount_type
 * @property string|null $description
 * @property int $coupon_id
 * @property string|null $max_redeem_type
 * @property float|null $max_redeem_rate
 * @property int|null $referred_user_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Transaction $transaction
 * @property \App\Model\Entity\Wallet[] $wallets
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Coupon $coupon
 * @property \App\Model\Entity\ReferredUser $referred_user
 */
class Wallet extends Entity
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
        'transaction_id' => true,
        'wallet_id' => true,
        'order_id' => true,
        'user_id' => true,
        'amount' => true,
        'is_expiry' => true,
        'expiry_date' => true,
        'amount_type' => true,
        'description' => true,
        'coupon_id' => true,
        'max_redeem_type' => true,
        'max_redeem_rate' => true,
        'referred_user_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'transaction' => true,
        'wallets' => true,
        'order' => true,
        'user' => true,
        'coupon' => true,
        'referred_user' => true,
    ];
}
