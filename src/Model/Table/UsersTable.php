<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\BelongsTo $Devices
 * @property \App\Model\Table\StoresTable&\Cake\ORM\Association\BelongsTo $Stores
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\BelongsTo $Addresses
 * @property \App\Model\Table\CartsTable&\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 * @property \App\Model\Table\UserAddressesTable&\Cake\ORM\Association\HasMany $UserAddresses
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserAddresses', [
            'foreignKey' => 'user_address_id',
        ]);
        $this->HasMany('Orders', [
            'foreignKey' => 'user_id',
          
         ]);
        $this->belongsTo('OrderDetails', [
            'foreignKey' => 'order_id',
        ]);
        // $this->hasMany('UserAddresses', [
        //     'foreignKey' => 'user_id',
        // ]);
        $this->belongsTo('Devices', [
			'foreignKey' => 'device_id',
			'joinType' => 'INNER',
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
    //         ->integer('id')
    //         ->allowEmptyString('id', null, 'create');

    //     $validator
    //         ->scalar('name')
    //         ->maxLength('name', 191)
    //         ->requirePresence('name', 'create')
    //         ->notEmptyString('name');

    //     $validator
    //         ->scalar('firm_name')
    //         ->maxLength('firm_name', 250)
    //         ->allowEmptyString('firm_name');

    //     $validator
    //         ->scalar('mobile')
    //         ->maxLength('mobile', 250)
    //         ->requirePresence('mobile', 'create')
    //         ->notEmptyString('mobile');

    //     $validator
    //         ->scalar('image')
    //         ->maxLength('image', 191)
    //         ->allowEmptyFile('image');

    //     $validator
    //         ->email('email')
    //         ->allowEmptyString('email');

    //     $validator
    //         ->scalar('password')
    //         ->maxLength('password', 191)
    //         ->allowEmptyString('password');

    //     $validator
    //         ->integer('otp')
    //         ->allowEmptyString('otp');

    //     $validator
    //         ->boolean('status')
    //         ->notEmptyString('status');

    //     $validator
    //         ->scalar('token')
    //         ->allowEmptyString('token');

    //     $validator
    //         ->scalar('gst_no')
    //         ->maxLength('gst_no', 250)
    //         ->allowEmptyString('gst_no');

    //     return $validator;
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
    //     $rules->add($rules->isUnique(['email']));
    //     //$rules->add($rules->existsIn(['role_id'], 'Roles'));

    //     $rules->add($rules->existsIn(['user_address_id'], 'UserAddresses'));

    //     return $rules;
    // }
}
