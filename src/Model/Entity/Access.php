<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Access Entity.
 *
 * @property int $id
 * @property string $ip
 * @property int $browser_id
 * @property int $cpu_id
 * @property int $device_id
 * @property int $engine_id
 * @property int $system_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $active
 */
class Access extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
