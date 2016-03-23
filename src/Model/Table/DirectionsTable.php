<?php
namespace App\Model\Table;

use App\Model\Entity\Direction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Directions Model
 *
 */
class DirectionsTable extends Table
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

        $this->table('directions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->add('latFrom', 'valid', ['rule' => 'numeric'])
            ->requirePresence('latFrom', 'create')
            ->notEmpty('latFrom');

        $validator
            ->add('lngFrom', 'valid', ['rule' => 'numeric'])
            ->requirePresence('lngFrom', 'create')
            ->notEmpty('lngFrom');

        $validator
            ->add('latTo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('latTo', 'create')
            ->notEmpty('latTo');

        $validator
            ->add('lngTo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('lngTo', 'create')
            ->notEmpty('lngTo');

        $validator
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
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
