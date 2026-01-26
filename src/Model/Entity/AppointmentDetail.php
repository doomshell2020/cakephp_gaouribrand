<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppointmentDetail Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $service_id
 * @property int $price
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Service $service
 */
class AppointmentDetail extends Entity
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
        'order_id' => true,
        'service_id' => true,
        'price' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'service' => true,
    ];
}
