<?php
App::uses('AppController', 'Controller');

/**
 * Statistics Controller
 *
 * @property Statistic $Statistic
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class StatisticsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'Flash');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index method
     * Retrieve default data settings and plot values
     *
     */
    public function index() {
        $this->Statistic->recursive = 0;
        //Findout latest year
        $latestYearID = $this->Statistic->getLatestYearID();
        //Default data for loading the page
        $defaultPlot = $this->Statistic->find('all', array(
            'fields' => array(
                'SUM(Statistic.num_of_adm) AS num_adm',
                'VhissDisease.value',
                'VhissDisease.id',
            ),
            'conditions' => array( 'Statistic.vhiss_year_id' => $latestYearID, ),
            'group' => array( 'Statistic.vhiss_disease_id' ),
            'order' => array( 'num_adm DESC' ),
            'limit' => 5,
        ));
        //Initialize datastore
        $defaultData = array();
        $defaultData['data'] = array('Number of admissions');
        $defaultData['categories'] = array();
        $defaultData['id'] = array();
        //Read all values into return array
        foreach ($defaultPlot as $defaultPoint) {
            array_push($defaultData['data'], $defaultPoint[0]['num_adm']);
            array_push($defaultData['categories'], $defaultPoint['VhissDisease']['value']);
            array_push($defaultData['id'], $defaultPoint['VhissDisease']['id']);
        }
        $this->set('plotData', $defaultData);

        //Filter attribute lists
        $this->set('filterListYear', $this->Statistic->VhissYear->find('list', array(
            'fields' => 'VhissYear.value',
            'order' => 'VhissYear.id DESC',
        )));
        $this->set('filterListAgeGroup', $this->Statistic->VhissAgeGroup->find('list', array(
            'fields' => 'VhissAgeGroup.value',
            'order' => 'VhissAgeGroup.id DESC',
        )));
        $this->set('filterListGender', $this->Statistic->VhissGender->find('list', array(
            'fields' => 'VhissGender.value',
            'order' => 'VhissGender.id DESC',
        )));

    }

    /**
     * getSplineGraphData method
     * Process ajax call for spline graph from client
     *
     * Only POST request is accepted
     */
    public function getSplineGraphData() {
        $this->autoRender = false;
        $this->response->type('json');

        if ($this->request->is(array('post'))) {
            //Collect request values
            $conditionsArray = array();
            //if (isset($this->request->data['requestGender'])) {
            //    $conditionsArray['Statistic.vhiss_gender_id'] = $this->request->data['requestGender'];
            //}
            if (isset($this->request->data['requestAgeGroup'])) {
                $conditionsArray['Statistic.vhiss_age_group_id'] = $this->request->data['requestAgeGroup'];
            }
            if (isset($this->request->data['requestDisease'])) {
                $conditionsArray['Statistic.vhiss_disease_id'] = $this->request->data['requestDisease'];
            }

            $splinePlotAll = $this->Statistic->find('all', array(
                'fields' => array(
                    'SUM(Statistic.num_of_adm) AS num_adm',
                    'VhissYear.value',
                ),
                'conditions' => $conditionsArray,
                'group' => array( 'Statistic.vhiss_year_id' ),
                'order' => array( 'VhissYear.value ASC' )
            ));

            //Get male data
            $conditionsArray['Statistic.vhiss_gender_id'] = 1;
            $splinePlotMale = $this->Statistic->find('all', array(
                'fields' => array(
                    'SUM(Statistic.num_of_adm) AS num_adm',
                    'VhissYear.value',
                ),
                'conditions' => $conditionsArray,
                'group' => array( 'Statistic.vhiss_year_id' ),
                'order' => array( 'VhissYear.value ASC' )
            ));

            //Get female data
            $conditionsArray['Statistic.vhiss_gender_id'] = 2;
            $splinePlotFemale = $this->Statistic->find('all', array(
                'fields' => array(
                    'SUM(Statistic.num_of_adm) AS num_adm',
                    'VhissYear.value',
                ),
                'conditions' => $conditionsArray,
                'group' => array( 'Statistic.vhiss_year_id' ),
                'order' => array( 'VhissYear.value ASC' )
            ));

            //Initialize datastore
            $splineData = array();
            $splineData['data'] = array(array('All Gender'), array('Male'), array('Female'));
            $splineData['categories'] = array();
            //Read all values into return array
            foreach ($splinePlotAll as $splinePoint) {
                array_push($splineData['data'][0], $splinePoint[0]['num_adm']);
                array_push($splineData['categories'], $splinePoint['VhissYear']['value']);
            }
            foreach ($splinePlotMale as $splinePoint) {
                array_push($splineData['data'][1], $splinePoint[0]['num_adm']);
                array_push($splineData['categories'], $splinePoint['VhissYear']['value']);
            }
            foreach ($splinePlotFemale as $splinePoint) {
                array_push($splineData['data'][2], $splinePoint[0]['num_adm']);
                array_push($splineData['categories'], $splinePoint['VhissYear']['value']);
            }

            $this->response->body(json_encode($splineData));
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }

    /**
     * getFilteredGraphData method
     * Process ajax call for bar graph from client
     *
     * Only POST request is accepted
     */
    public function getFilteredGraphData() {
        $this->autoRender = false;
        $this->response->type('json');

        if ($this->request->is(array('post'))) {
            //Collect request values
            $conditionsArray = array();
            if (isset($this->request->data['requestGender'])) {
                $conditionsArray['Statistic.vhiss_gender_id'] = $this->request->data['requestGender'];
            }
            if (isset($this->request->data['requestAgeGroup'])) {
                $conditionsArray['Statistic.vhiss_age_group_id'] = $this->request->data['requestAgeGroup'];
            }
            if (isset($this->request->data['requestYear'])) {
                $conditionsArray['Statistic.vhiss_year_id'] = $this->request->data['requestYear'];
            } else {
                //Findout latest year
                $conditionsArray['Statistic.vhiss_year_id'] = $this->Statistic->getLatestYearID();
            }

            $barPlot = $this->Statistic->find('all', array(
                'fields' => array(
                    'SUM(Statistic.num_of_adm) AS num_adm',
                    'VhissDisease.value',
                    'VhissDisease.id',
                ),
                'conditions' => $conditionsArray,
                'group' => array( 'Statistic.vhiss_disease_id' ),
                'order' => array( 'num_adm DESC' ),
                'limit' => 5,
            ));

            //Initialize datastore
            $barData = array();
            $barData['data'] = array('Number of admissions');
            $barData['categories'] = array();
            $barData['id'] = array();
            //Read all values into return array
            foreach ($barPlot as $barPoint) {
                array_push($barData['data'], $barPoint[0]['num_adm']);
                array_push($barData['categories'], $barPoint['VhissDisease']['value']);
                array_push($barData['id'], $barPoint['VhissDisease']['id']);
            }

            $this->response->body(json_encode($barData));

            //Set filtered diseases are favourite
            $this->Session->write('Dashboard.preferredDiseases', $barData['id']);
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }
}
