<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class FaqCatQuestionTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('faq_cat_question');
        $this->setPrimaryKey('id');        	
        $this->belongsTo('Faq', [
            'foreignKey' => 'faq_cat_id',
            'joinType' => 'LEFT',
        ]);
    }

}
