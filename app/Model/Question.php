<?php
App::uses('AppModel', 'Model');

/**
 * Question Model
 *
 */
class Question extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'disease_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please choose which disease this question belongs to',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Question cannot be empty',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'answer' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'You must provide an answer of this question',
                'allowEmpty' => false,
                'required' => true,
            ),
            'enumerated' => array(
                'rule' => array('answerEnumCheck'),
                'message' => 'Answer must be A, B, C or D',
                'allowEmpty' => false,
                'required' => true,
            ),
            'threeOptionCheck' => array(
                'rule' => array('checkInvalidAnswer'),
                'message' => 'An empty field cannot be chosen as answer',
            ),
        ),
        'answer_a' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Answer A cannot be empty',
                'allowEmpty' => false,
                'required' => 'create',
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 1023),
                'message' => 'Answer A is too long',
                'required' => 'create',
            ),
        ),
        'answer_b' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Answer B cannot be empty',
                'allowEmpty' => false,
                'required' => 'create',
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 1023),
                'message' => 'Answer B is too long',
                'required' => 'create',
            ),
        ),
        'answer_c' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 1023),
                'message' => 'Answer C is too long',
            ),
        ),
        'answer_d' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 1023),
                'message' => 'Answer D is too long',
            ),
            'threeOptionCheck' => array(
                'rule' => array('checkJumpField'),
                'message' => 'Please leave option D empty and move third answer to option C field',
            ),
        ),
    );
    var $name = "Question";
    var $belongsTo = array(
        'VhissDisease' => array(
            'className' => 'VhissDisease',
            'foreignKey' => 'disease_id'
        ),
    );

    /**
     * Check if answer field contains correct type of data
     *
     * @param $dataset
     * @return bool
     */
    public function answerEnumCheck($dataset) {
        //Get key of first item in array
        $value = reset($dataset);
        return (in_array($value, array('a', 'b', 'c', 'd')));
    }

    /**
     * Check if a three-option question has option D filled
     */
    public function checkJumpField() {
        $dataset = $this->data[$this->name];
        if (empty($dataset['answer_c']) && !empty($dataset['answer_d'])) return false;
        return true;
    }

    /**
     * Check if an invalid answer is given when some fields are empty
     */
    public function checkInvalidAnswer() {
        $dataset = $this->data[$this->name];
        if (empty($dataset['answer_a']) && $dataset['answer'] == 'a') return false;
        if (empty($dataset['answer_b']) && $dataset['answer'] == 'b') return false;
        if (empty($dataset['answer_c']) && $dataset['answer'] == 'c') return false;
        if (empty($dataset['answer_d']) && $dataset['answer'] == 'd') return false;
        return true;
    }
}