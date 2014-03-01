<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $ajaxFunc = array();
    public $options = array();
    public $loginCookieName = 'DreambCloudLogin';
    
	public $components = array(
        'Acl',
        'Cookie',
        'Session',
		'RequestHandler',
		'Auth' => array(
			'authError' => "L'accès à cette page ne vous est pas autorisé.",
			'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
			'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
                'admin' => false,
                'plugin' => false
            ),
			'loginRedirect' => array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => false,
                'plugin' => false
            ),
			'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login',
                'admin' => false,
                'plugin' => false
            ),
			'authenticate' => array(
				'Form' => array(
					'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'scope' => array('status' => 1)
				)
			)
		)
	);
	
	public $helpers = array(
	   'Js',
	   'BCloud',
	   'Html',
	   'Form',
	   'Session'
    );
	
	public function beforeFilter()
	{
		$this->layout = 'bCloud/default';
		
		$this->Cookie->name = 'DreamCookie';
		$this->Cookie->httpOnly = true;
		
        // 
        if (Configure::read('bCloud.Allow')) {
            $this->Auth->allow();
        }
		
        if (in_array($this->request->params['action'], $this->ajaxFunc)) {
            $this->layout = 'ajax';
			
			if (!$this->request->isAjax()) {
				return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
			}
        }
		
		if (array_key_exists('admin', $this->request->params) && (array_key_exists('plugin', $this->request->params))) {
			if ($this->request->params['admin'] && ($this->request->params['plugin'] === 'acl')) {
				$this->layout = 'default';
			}
		}
	}
    
    public function _exists($id)
    {
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        return true;
    }
	
    function _encrypt($string)
    {
        if(!$string) {
        	return false;
        }
        $_encryptData = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, 'SECURE_STRING_1', $string, MCRYPT_MODE_ECB, 'SECURE_STRING_2');
        return trim(base64_encode($_encryptData));
    }
    
    function _decrypt($string)
    {
        if(!$string) 
            return false; 
        $_encryptData = base64_decode($string);
        $_decryptData = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'SECURE_STRING_1', $_encryptData, MCRYPT_MODE_ECB, 'SECURE_STRING_2');
        return trim($_decryptData);
    }
}
