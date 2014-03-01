<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * ProformaStatut Model
 *
 */
class ProformaStatut extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Nom requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'isExist' => array (
                'rule' => array ('isExist'),
                'message' => 'Cet mode existe déjà. ',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		),
	);
    
    public function isExist()
    {
        $options['conditions'] = array(
            $this->alias.'.name' => $this->data[$this->alias]['name'],
        );
        
        if ($this->find('count', $options) > 0) {
            return false;
        }
        return true;
    }
    
    public function beforeSave($options = array())
    {
        $this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
    }
}
