<?php
App::uses('AppController', 'Controller');

/**
 * Feedback Controller
 *
 * @property Feedback $Feedback
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class FeedbackController extends AppController {

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
     * admin_index method
     * List feedback in backend list
     *
     * @param bool $replied
     * @return void
     */
    public function admin_index($replied = null) {
        if ($this->isAuthorized()) {
            $this->Feedback->recursive = 0;
            $feedbackSetOptions = array(
                'order' => array(
                    'Feedback.status' => 'desc',
                    'Feedback.created' => 'desc',
                ),
                'conditions' => array(
                    'Feedback.status' => 1,
                ),
            );
            if (!is_null($replied) && $replied == true) {
                $feedbackSetOptions['conditions']['Feedback.status'] = 0;
                $this->set('repliedOnly', $replied);
            }
            $this->set('feedbackSets', $this->Feedback->find('all', $feedbackSetOptions));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * add method
     * Allow end user add feedback items
     * This method do not need user to be authorized (front-end post request)
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Feedback->create();
            if ($this->Feedback->save($this->request->data)) {
                $this->Flash->frontsuccess(__('Your feedback is recorded and will be reviewed as soon as possible. Thank you very much! '));
                return $this->redirect(array('action' => 'add'));
            } else {
                $this->Flash->frontdanger(__('Please check required fields before submit your feedback. '));
            }
        }
    }

    /**
     * admin_review method
     * Review page for feedback in backend.
     * TODO: Allow direct reply in backend and send email to user
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_review($id = null) {
        if ($this->isAuthorized()) {
            if (!$this->Feedback->exists($id)) {
                throw new NotFoundException(__('Invalid administrator'));
            }
            $options = array('conditions' => array('Feedback.' . $this->Feedback->primaryKey => $id));
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Feedback']['id'] = $id; //Attach id before save
                if ($this->Feedback->save($this->request->data)) {
                    $this->Flash->bssuccess(__('Feedback has been reviewed successfully'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('Feedback review could not be saved. Please try again'), array('key' => 'form'));
                }
            } else {
                $this->request->data = $this->Feedback->find('first', $options);
            }
            $this->set('thisFeedback', $this->Feedback->find('first', $options));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_mark method
     * Mark feedback as replied
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_mark($id = null) {
        if ($this->isAuthorized()) {
            $this->Feedback->id = $id;
            if (!$this->Feedback->exists()) {
                throw new NotFoundException(__('Invalid feedback item'));
            }
            //Check if feedback already replied
            if ($this->Feedback->isReplied($id)) {
                throw new NotFoundException(__('Feedback has already marked as replied'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->Feedback->saveField('status', 0)) {
                $this->Flash->bssuccess(__('Selected feedback is marked as replied'));
            } else {
                $this->Flash->bsdanger(__('Feedback cannot be marked. Please try again'));
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }
}
