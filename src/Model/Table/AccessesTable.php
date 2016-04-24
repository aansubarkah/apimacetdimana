<?php
namespace App\Model\Table;

use App\Model\Entity\Access;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accesses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Browsers
 * @property \Cake\ORM\Association\BelongsTo $Cpus
 * @property \Cake\ORM\Association\BelongsTo $Devices
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\BelongsTo $Systems
 * @property \Cake\ORM\Association\BelongsTo $Pages
 */
class AccessesTable extends Table
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

        $this->table('accesses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Browsers', [
            'foreignKey' => 'browser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cpus', [
            'foreignKey' => 'cpu_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pages', [
            'foreignKey' => 'page_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('ip', 'create')
            ->notEmpty('ip');

        $validator
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['browser_id'], 'Browsers'));
        $rules->add($rules->existsIn(['cpu_id'], 'Cpus'));
        $rules->add($rules->existsIn(['device_id'], 'Devices'));
        $rules->add($rules->existsIn(['engine_id'], 'Engines'));
        $rules->add($rules->existsIn(['system_id'], 'Systems'));
        $rules->add($rules->existsIn(['page_id'], 'Pages'));
        return $rules;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'alternative';
    }
}
