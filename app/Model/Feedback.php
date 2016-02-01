<?php
App::uses('AppModel', 'Model');

/**
 * Feedback Model
 *
 */
class Feedback extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter your name',
				'allowEmpty' => false,
				'required' => 'create',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Your name is too long',
				'required' => 'create',
			),
		),
		'email' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter your email address so we can contact you later',
				'allowEmpty' => false,
				'required' => 'create',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Your email address is too long',
				'required' => 'create',
			),
			'emailAddress' => array(
				'rule' => array('email', true),
				'message' => 'You must enter a valid email address',
				'required' => 'create',
			),
		),
		'content' => array(
			'required' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter your feedback',
				'allowEmpty' => false,
				'required' => 'create',
			),
		),
//		'captcha' => array(
//			'captcha' => array(
//				'rule' => array('captchaCheck'),
//				'message' => 'Please validate as instructed before send out your feedback',
//				'required' => 'create',
//			),
//		),
	);

//	public function captchaCheck() {
//
//	}

	/**
	 * Check if feedback is replied (status = 0)
	 * Remember check existence of feedback before use
	 *
	 * @param $feedbackId
	 * @return bool
	 */
	public function isReplied($feedbackId) {
		$thisFeedback = $this->find(
			'first',
			array(
				'fields' => array(
					'Feedback.id',
					'Feedback.status'
				),
				'conditions' => array(
					'Feedback.id' => $feedbackId
				)
			)
		);
		return $thisFeedback[$this->alias]['status'] === 0;
	}

	public function beforeSave($options = array()) {
		//Sanitize public input before store to avoid attack
		if (isset($this->data[$this->alias]['name'])) {
			$this->data[$this->alias]['name'] = filter_var($this->data[$this->alias]['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (isset($this->data[$this->alias]['email'])) {
			$this->data[$this->alias]['email'] = filter_var($this->data[$this->alias]['email'], FILTER_SANITIZE_EMAIL);
		}
		if (isset($this->data[$this->alias]['content'])) {
			$this->data[$this->alias]['content'] = filter_var($this->data[$this->alias]['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		return parent::beforeSave($options);
	}
}
