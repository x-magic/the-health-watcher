<?php
App::uses('AppModel', 'Model');

/**
 * Post Model
 *
 */
class Post extends AppModel {
    public $validate = array(
        'disease_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Invalid argument given',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please do not submit empty content',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'userid' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please login before sending post',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'username' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please login before sending post',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
    );

    var $name = "Post";
    var $belongsTo = array(
        'VhissDisease' => array(
            'className' => 'VhissDisease',
            'foreignKey' => 'disease_id'
        ),
    );
    var $hasMany = array(
        'Thread' => array(
            'className' => 'Post',
            'foreignKey' => 'parent_id'
        ),
    );

    /**
     * Check if given thread is a parent thread
     * @param $id
     * @return bool
     */
    public function isValudParentThread($id) {
        //Get parent_id field of given id
        $this->id = $id;
        $parent = is_null($this->field('parent_id'));
        $validity = $this->field('status') == 1;
        //return its result
        return $parent && $validity;
    }

    public function beforeSave($options = array()) {
        //Sanitize public input before store to avoid attack
        if (isset($this->data[$this->alias]['title'])) {
            $this->data[$this->alias]['title'] = filter_var($this->data[$this->alias]['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if (isset($this->data[$this->alias]['content'])) {
            $this->data[$this->alias]['content'] = filter_var($this->data[$this->alias]['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return parent::beforeSave($options);
    }
}