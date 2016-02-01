<?php
App::uses('AppController', 'Controller');

/**
 * Announcements Controller
 *
 * @property Announcement $Announcement
 */
class AnnouncementsController extends AppController {

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
     * List announcements
     *
     * @return void
     */
    public function admin_index() {
        if ($this->isAuthorized()) {
            $this->Announcement->recursive = 0;
            $this->set('announcements', $this->Announcement->find('all', array(
                'order' => array('Announcement.date' => 'desc'),
                'conditions' => array('Announcement.status' => 1),
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_add method
     * Process new announcement request
     *
     * @return void
     */
    public function admin_add() {
        if ($this->isAuthorized()) {
            if ($this->request->is('post')) {
                $this->Announcement->create();
                if ($this->Announcement->save($this->request->data)) {
                    $this->Flash->bssuccess(__('A new announcement has been added'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('New announcement could not be added. Please try again'), array('key' => 'form'));
                }
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Announcement->VhissDisease->find('list', array(
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
     * Process update announcement request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if ($this->isAuthorized()) {
            if (!$this->Announcement->exists($id)) {
                throw new NotFoundException(__('Invalid announcement'));
            }
            $this->Announcement->id = $id;
            //Check if announcement already disabled
            if ($this->Announcement->field('status') == 0) {
                throw new NotFoundException(__('Announcement was deleted'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Announcement']['id'] = $id; //Attach announcement id before save
                if ($this->Announcement->save($this->request->data)) {
                    $this->Flash->bssuccess(__('New information of announcement has been saved'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('Announcement could not be saved. Please try again'), array('key' => 'form'));
                }
            } else {
                $this->request->data = $this->Announcement->find('first', array('conditions' => array('Announcement.' . $this->Announcement->primaryKey => $id)));
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Announcement->VhissDisease->find('list', array(
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
     * Process delete announcement request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if ($this->isAuthorized()) {
            $this->Announcement->id = $id;
            if (!$this->Announcement->exists()) {
                throw new NotFoundException(__('Invalid announcement'));
            }
            //Check if announcement already disabled
            if ($this->Announcement->field('status') == 0) {
                throw new NotFoundException(__('Announcement already deleted'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->Announcement->saveField('status', 0)) {
                $this->Flash->bssuccess(__('Announcement has been deleted'));
            } else {
                $this->Flash->bsdanger(__('Announcement could not be deleted. Please try again'));
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }
}
