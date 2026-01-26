<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string $mrp
 * @property string $net_price
 * @property string $margin
 * @property string $gst_id
 * @property string $description
 * @property string $image
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Gst $gst
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
    //  * @var array
    //  */
    // protected $_accessible = [
    //     'name' => true,
    //     'mrp' => true,
    //     'net_price' => true,
    //     'margin' => true,
    //     'gst_id' => true,
    //     'description' => true,
    //     'image' => true,
    //     'status' => true,
    //     'created' => true,
    //     'gst' => true,
    //     'category_id' => true,
    //     'weight' => true,
    //     'freightfree' => true,
    // ];
}
