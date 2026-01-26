<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Slot Entity
 *
 * @property int $id
 * @property string $weekday
 * @property \Cake\I18n\FrozenTime $mintime
 * @property \Cake\I18n\FrozenTime $maxtime
 * @property bool $status
 *
 * @property \App\Model\Entity\Appointment[] $appointments
 */
class Slot extends Entity
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
        'weekday' => true,
        'mintime' => true,
        'maxtime' => true,
        'status' => true,
        'appointments' => true,
    ];
    protected function _getSlotName()
    {
        return date('h A', strtotime($this->mintime)) . ' to ' . date('h A', strtotime($this->maxtime));
    }
}
