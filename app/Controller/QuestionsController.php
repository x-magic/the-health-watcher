<?php
App::uses('AppController', 'Controller');

/**
 * Questions Controller
 *
 * @property Question $Question
 */
class QuestionsController extends AppController {

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
     * Randomly assign user a question from database
     */
    public function index() {
        //Set a session to let view method know question is randomly selected
        $this->Session->write('Question.randomlyChosen', true);
        $questionOptions = array('conditions' => array('Question.status' => 1));
        //Select questions in uesr preferred diseases
        $favouriteIDs = $this->Session->read('Dashboard.preferredDiseases');
        if (!is_null($favouriteIDs)) {
            $questionOptions['conditions']['Question.disease_id'] = $favouriteIDs;
            $this->Session->write('Question.preferredChosen', true);
        }
        $selectedCategory = $this->Session->read('Question.selectedCategory');
        if (!is_null($selectedCategory)) {
            $questionOptions['conditions']['Question.disease_id'] = $selectedCategory;
        }
        $listOfQuestionIDs = $this->Question->find('list', $questionOptions);
        $randomQuestionID = array_rand($listOfQuestionIDs);
        $this->redirect(array('action' => 'view', $randomQuestionID));
    }

    /**
     * view method
     * Display question by given question id
     * @param int $id
     */
    public function view($id = null) {
        $question = $this->Question->find('first', array('conditions' => array('Question.id' => $id, 'Question.status' => 1)));
        if (count($question) > 0) {
            $this->set('question', $question);
            //Filter attribute lists
            $validDiseaseIDs = $this->Question->find('list', array(
                'fields' => 'disease_id',
                'order' => 'disease_id ASC',
                'conditions' => array('status' => 1),
                'group' => 'disease_id',
            ));
            $this->set('filterListDisease', $this->Question->VhissDisease->find('list', array(
                'fields' => 'VhissDisease.value',
                'order' => 'VhissDisease.value ASC',
                'conditions' => array('VhissDisease.id' => $validDiseaseIDs),
            )));
        } else {
            throw new NotFoundException("Question is not exist or already deleted. Sorry for inconvenience. ");
        }
    }

    public function selectCategory($id = null) {
        if ($id == 0) {
            //Delete session value when select all categories
            $this->Session->delete('Question.selectedCategory');
        } else {
            //Check if given category id is valid
            if (!$this->Question->VhissDisease->exists($id)) {
                throw new NotFoundException(__('Invalid category'));
            }
            //Write this category to session
            $this->Session->write('Question.selectedCategory', $id);
        }
        //Redirect user index to get a new question
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     * List questions
     *
     * @return void
     */
    public function admin_index() {
        if ($this->isAuthorized()) {
            $this->Question->recursive = 0;
            $this->set('questions', $this->Question->find('all', array(
                'order' => array('Question.id' => 'desc'),
                'conditions' => array('Question.status' => 1),
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_add method
     * Process new question request
     *
     * @return void
     */
    public function admin_add() {
        if ($this->isAuthorized()) {
            if ($this->request->is('post')) {
                $this->Question->create();
                if ($this->Question->save($this->request->data)) {
                    $this->Flash->bssuccess(__('A new question has been added'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('New question could not be added. Please try again'), array('key' => 'form'));
                }
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Question->VhissDisease->find('list', array(
                'fields' => 'VhissDisease.value',
                'order' => 'VhissDisease.value ASC',
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_edit method
     * Process update question request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if ($this->isAuthorized()) {
            if (!$this->Question->exists($id)) {
                throw new NotFoundException(__('Invalid question'));
            }
            $this->Question->id = $id;
            //Check if question already disabled
            if ($this->Question->field('status') == 0) {
                throw new NotFoundException(__('Question was deleted'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Question']['id'] = $id; //Attach question id before save
                if ($this->Question->save($this->request->data)) {
                    $this->Flash->bssuccess(__('New information of question has been saved'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('Question could not be saved. Please try again'), array('key' => 'form'));
                }
            } else {
                $this->request->data = $this->Question->find('first', array('conditions' => array('Question.' . $this->Question->primaryKey => $id)));
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Question->VhissDisease->find('list', array(
                'fields' => 'VhissDisease.value',
                'order' => 'VhissDisease.value ASC',
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_delete method
     * Process delete question request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if ($this->isAuthorized()) {
            $this->Question->id = $id;
            if (!$this->Question->exists()) {
                throw new NotFoundException(__('Invalid question'));
            }
            //Check if question already disabled
            if ($this->Question->field('status') == 0) {
                throw new NotFoundException(__('Question already deleted'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->Question->saveField('status', 0)) {
                $this->Flash->bssuccess(__('Question has been deleted'));
            } else {
                $this->Flash->bsdanger(__('Question could not be deleted. Please try again'));
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }
}
