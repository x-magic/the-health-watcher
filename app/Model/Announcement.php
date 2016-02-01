<?php
App::uses('AppModel', 'Model');

/**
 * Announcement Model
 *
 */
class Announcement extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'disease_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please choose which disease this announcement belongs to',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please choose a date for this announcement',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide content of this announcement',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
    );
    var $name = "Announcement";
    var $belongsTo = array(
        'VhissDisease' => array(
            'className' => 'VhissDisease',
            'foreignKey' => 'disease_id'
        ),
    );
}