<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Service Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\AppointmentDetail[] $appointment_details
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\ServiceImage[] $service_images
 */
class Service extends Entity
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
        'name' => true,
        'price' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'category_id' => true,
        'subcategory_id' => true,
        'description' => true,
        'appointment_details' => true,
        'carts' => true,
        'service_images' => true,
    ];
}
