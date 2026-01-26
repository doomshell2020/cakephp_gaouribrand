<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SlotsDayTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('slots_day');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Slots', [
            'foreignKey' => 'slots_day_id',
            'joinType' => 'INNER',
        ]);
    }
}