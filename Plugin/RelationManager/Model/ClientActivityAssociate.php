<?php
App::uses('RelationManagerAppModel', 'RelationManager.Model');
/**
 * ClientActivity Model
 *
 * @property Client $Client
 */
class ClientActivityAssociate extends RelationManagerAppModel
{
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $belongsTo = array(
        'Client' => array(
            'className' => 'RelationManager.Client',
        ),
	);

}
