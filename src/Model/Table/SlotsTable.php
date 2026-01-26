<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SlotsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tbl_slots');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SlotsDay', [
            'foreignKey' => 'slots_day_id',
            'joinType' => 'INNER',
        ]);
    }

}
