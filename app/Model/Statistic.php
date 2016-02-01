<?php
App::uses('AppModel', 'Model');

/**
 * Statistic Model
 *
 */

class Statistic extends AppModel {

    var $name = "Statistic";
    var $belongsTo = array(
        'VhissGender' => array(
            'className' => 'VhissGender',
            'foreignKey' => 'vhiss_gender_id'
        ),
        'VhissDisease' => array(
            'className' => 'VhissDisease',
            'foreignKey' => 'vhiss_disease_id'
        ),
        'VhissYear' => array(
            'className' => 'VhissYear',
            'foreignKey' => 'vhiss_year_id'
        ),
        'VhissAgeGroup' => array(
            'className' => 'VhissAgeGroup',
            'foreignKey' => 'vhiss_age_group_id'
        ),

    );

    /**
     * getLatestYearID method
     * Return most recent year id in Vhiss_Year database
     * Only return latest year by id-wise, not comparing the actual value.
     *
     * @return int
     */
    public function getLatestYearID() {
        $lastYearArray = $this->VhissYear->find('first', array('order' => array('id' => 'DESC')));
        return $lastYearArray['VhissYear']['id'];
    }
}