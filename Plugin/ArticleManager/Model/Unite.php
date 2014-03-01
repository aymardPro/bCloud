<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * Unite Model
 *
 */
class Unite extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Le nom est requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isNameExist' => array (
                'rule' => array ('isNameExist'),
                'message' => 'Cette unité est déjà utilisé.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
	);
    
    public function isNameExist()
    {
        if ($this->findByName($this->data[$this->alias]['name'])) {
            return false;
        }
        return true;
    }
    
    public function register($data)
    {
        $this->data = $data;
        
        if ($this->save($this->data)) {
            return true;
        }
        return false;
    }
}
