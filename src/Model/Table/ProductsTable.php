<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProductsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('image');
        $this->setPrimaryKey('id');

        $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id',
            'joinType' => 'LEFT',
        ]);


        $this->hasMany('ProductCommision', [
            'foreignKey' => 'product_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('OrderDetails', [
            'foreignKey' => 'product_id',
            'joinType' => 'LEFT',
        ]);

    
        $this->belongsTo('Users', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'INNER',
        ]);
        
    }

}
