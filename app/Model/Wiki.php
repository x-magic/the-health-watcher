<?php
App::uses('AppModel', 'Model');

/**
 * Wiki Model
 *
 */
class Wiki extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please type in a title',
                'allowEmpty' => false,
                'required' => true,
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Title is too long',
            ),
        ),
        'source' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Source is too long',
            ),
        ),
        'url' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 2047),
                'message' => 'Source url is too long',
            ),
        ),
        'definition' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter definition',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
    );
    var $name = "Wiki";
    var $belongsTo = array(
        'VhissDisease' => array(
            'className' => 'VhissDisease',
            'foreignKey' => 'vhiss_disease_id'
        ),
    );
}