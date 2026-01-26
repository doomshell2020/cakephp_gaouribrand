<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coupons Model
 *
 * @property \App\Model\Table\VendorsTable&\Cake\ORM\Association\BelongsTo $Vendors
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \App\Model\Entity\Coupon get($primaryKey, $options = [])
 * @method \App\Model\Entity\Coupon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Coupon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Coupon|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coupon saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CouponsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('coupons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Categories', [
            'foreignKey' => 'coupon_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'coupons_categories',
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'coupon_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'coupons_products',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    // public function validationDefault(Validator $validator)
    // {

    //     $validator
    //         ->scalar('code')
    //         ->maxLength('code', 50)
    //         ->requirePresence('code', 'create')
    //         ->notEmptyString('code');

    //     $validator
    //         ->scalar('applicable_to')
    //         ->requirePresence('applicable_to', 'create')
    //         ->notEmptyString('applicable_to');

    //     $validator
    //         ->scalar('applicable_type')
    //         ->requirePresence('applicable_type', 'create')
    //         ->notEmptyString('applicable_type');

    //     $validator
    //         ->scalar('discount_type')
    //         ->requirePresence('discount_type', 'create')
    //         ->notEmptyString('discount_type');

    //     $validator
    //         ->numeric('minimum_order_value')
    //         ->requirePresence('minimum_order_value', 'create')
    //         ->notEmptyString('minimum_order_value');

    //     $validator
    //         ->numeric('maximum_discount')
    //         ->requirePresence('maximum_discount', 'create')
    //         ->notEmptyString('maximum_discount');

    //     $validator
    //         ->numeric('discount_rate')
    //         ->requirePresence('discount_rate', 'create')
    //         ->notEmptyString('discount_rate');

    //     $validator
    //         ->dateTime('valid_from')
    //         ->requirePresence('valid_from', 'create')
    //         ->notEmptyDateTime('valid_from');

    //     $validator
    //         ->dateTime('valid_to')
    //         ->requirePresence('valid_to', 'create')
    //         ->notEmptyDateTime('valid_to');

    //     $validator
    //         ->scalar('max_redeem_type')
    //         ->requirePresence('max_redeem_type', 'create')
    //         ->notEmptyString('max_redeem_type');

    //     $validator
    //         ->numeric('max_redeem_rate')
    //         ->requirePresence('max_redeem_rate', 'create')
    //         ->notEmptyString('max_redeem_rate');

    //      return $validator;
    // }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));

    //     return $rules;
    // }
}
