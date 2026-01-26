<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property int $mobile
 * @property string|null $email
 * @property int|null $otp
 * @property bool $status
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Appointment[] $appointments
 * @property \App\Model\Entity\Cart[] $carts
 */
class User extends Entity
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
    //     'name' => true,
    //     'mobile' => true,
    //     'email' => true,
    //     'otp' => true,
    //     'status' => true,
    //     'token' => true,
    //     'created' => true,
    //     'modified' => true,
    //     'appointments' => true,
    //     'carts' => true,
    //     'role_id' => true,	
    //     'store_id' => true,
    //     'image' => true,
    //     'password' => true,
    //     'state_id' => true,
    //     'firm_name' => true,
    //     'gst_no' => true,
    //     'user_address_id' => true,
    //     'notification_counter' => true,
    //      'address' => true,
    //     'instagram' => true,
    //     'fackbook' => true,
    //     'twitter' => true,
    //      'youtube' => true,
    // ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
