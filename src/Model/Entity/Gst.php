<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gst Entity
 *
 * @property int $id
 * @property string $name
 * @property string $rate
 * @property string|null $cgst
 * @property string|null $sgst
 * @property string|null $igst
 * @property string $status
 * @property \Cake\I18n\FrozenTime $craeted
 *
 * @property \App\Model\Entity\Product[] $products
 */
class Gst extends Entity
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
        'rate' => true,
        'cgst' => true,
        'sgst' => true,
        'igst' => true,
        'status' => true,
        'craeted' => true,
        'products' => true,
    ];
}
