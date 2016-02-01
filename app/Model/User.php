<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth'); //Import password hasher for login and register

/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 * Please do not change this value
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * Validation rules
 * Prefer to CakePHP documentation for more info
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'A username is required',
				'allowEmpty' => false,
				'required' => 'create',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 127),
				'message' => 'Username is too long',
				'required' => 'create',
			),
			'unique' => array(
				'rule' => array('isUniqueUsername'),
				'message' => 'This username has been used',
				'required' => 'create',
			),
			'alphaNumericDashUnderscore' => array(
				'rule' => array('alphaNumericDashUnderscore'),
				'message' => 'Username only accepts letters, numbers, dashes and underscores',
				'required' => 'create',
			),
		),
		'password' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'A password is required',
				'required' => 'create',
			),
			'min_length' => array(
				'rule' => array('minLength', 8),
				'message' => 'Your password is too short',
				'required' => 'create',
			),
		),
		'password_confirm' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'Please confirm your password',
				'allowEmpty' => false,
				'required' => 'create',
			),
			'equalToPassword' => array(
				'rule' => array('equalToField', 'password'),
				'message' => 'The confirm password does not match',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
		'password_update' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'A password is required',
				'allowEmpty' => false,
				'required' => 'update',
			),
			'min_length' => array(
				'rule' => array('minLength', 8),
				'message' => 'Your password is too short',
				'allowEmpty' => false,
				'required' => 'update',
			),
		),
		'password_confirm_update' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'Please confirm your password',
				'allowEmpty' => false,
				'required' => 'update',
			),
			'equalToPassword' => array(
				'rule' => array('equalToField', 'password_update'),
				'message' => 'The confirm password does not match',
				'required' => 'update',
			),
		),
	);

	/**
	 * Validate if username is unique
	 *
	 * @param $dataset
	 * @return bool
	 */
	public function isUniqueUsername($dataset) {
		$username = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id',
					'User.username'
				),
				'conditions' => array(
					'User.username' => $dataset['username']
				)
			)
		);

		if (!empty($username)) {
			if ($this->data[$this->alias]['username'] === $username['User']['username']) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	/**
	 * Check if string contains only alphanumeric characters, dashes and underscores
	 *
	 * @param $dataset
	 * @return bool
	 */
	public function alphaNumericDashUnderscore($dataset) {
		$value = reset($dataset); //Clean up input mess before parse
		return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
	}

	/**
	 * Check if two fields has the same content
	 *
	 * @param $dataset
	 * @param $field
	 * @return bool
	 */
	public function equalToField($dataset, $field) {
		//Get key of first item in array
		reset($dataset);
		$fieldName = key($dataset);
		return $this->data[$this->name][$field] === $this->data[$this->name][$fieldName];
	}

	/**
	 * Check if user is deleted (status = 0)
	 * Remember check existence of user before use
	 *
	 * @param $userid
	 * @return bool
	 */
	public function isDisabled($userid) {
		$thisUser = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id',
					'User.status'
				),
				'conditions' => array(
					'User.id' => $userid
				)
			)
		);
		return $thisUser[$this->alias]['status'] === 0;
	}

	/**
	 * Before Save filter method
	 * This method hashes password or password_update before put into database
	 *
	 * @param array $options
	 * @return bool
	 */
	public function beforeSave($options = array()) {
		//Initialize password hasher
		$pwHasher = new BlowfishPasswordHasher();
		//Hash password before put into db
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = $pwHasher->hash($this->data[$this->alias]['password']);
		}
		//Hash updated password as well
		if (isset($this->data[$this->alias]['password_update'])) {
			$this->data[$this->alias]['password'] = $pwHasher->hash($this->data[$this->alias]['password_update']);
		}
		return parent::beforeSave($options);
	}
}
