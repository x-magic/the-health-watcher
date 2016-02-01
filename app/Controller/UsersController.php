<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

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
     * login method
     * Processing login request
     *
     * @return void
     */
    public function login() {
        //If logged in already, redirect to...
        if ($this->Session->check('Auth.User')) {
            return $this->redirect(array('action' => 'dashboard', 'admin' => true));
        }

        //Process login request when submit
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $status = $this->Auth->user('status');
                if ($status != 0) {
                    $this->Flash->bssuccess(__('Welcome back, ' . $this->Auth->user('username')));
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    // this is a deleted user
                    $this->Auth->logout();
                    $this->Flash->bsdanger(__('You account has been deleted'), array('key' => 'form'));
                }
            } else {
                $this->Flash->bsdanger(__('Invalid username or password'), array('key' => 'form'));
            }
        }
        $this->layout = 'blank';
        $this->set('title_for_layout', 'Login');
    }

    /**
     * admin_logout method, wrapper of auth module logout method
     *
     * @return void
     */
    public function admin_logout() {
        if ($this->isAuthorized()) {
            $this->Flash->bssuccess(__('You are logged out, ' . $this->Auth->user('username')));
            return $this->redirect($this->Auth->logout());
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_dashboard
     * Dashboard function.
     *
     * - Retrieve number of not yet replied feedback
     */
    public function admin_dashboard() {
        if ($this->isAuthorized()) {
            //Load feedback counter
            $this->loadModel('Feedback');
            $this->set('numberOfNewFeedback', $this->Feedback->find('count', array(
                'conditions' => array(
                    'Feedback.status' => 1,
                ),
            )));
            //Load wiki counter
            $this->loadModel('Wiki');
            $this->set('numberOfWiki', $this->Wiki->find('count', array(
                'conditions' => array(
                    'Wiki.status >' => '0',
                ),
            )));
            //Load announcement counter
            $this->loadModel('Announcement');
            $this->set('numberOfAnnouncement', $this->Announcement->find('count', array(
                'conditions' => array(
                    'Announcement.status' => 1,
                ),
            )));
            //Load questions counter
            $this->loadModel('Question');
            $this->set('numberOfQuestion', $this->Question->find('count', array(
                'conditions' => array(
                    'Question.status' => 1,
                ),
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_index method
     * List administrators
     *
     * @return void
     */
    public function admin_index() {
        if ($this->isAuthorized()) {
            $this->User->recursive = 0;
            $this->set('users', $this->User->find('all', array(
                'order' => array('User.username' => 'asc'),
                'conditions' => array('User.status' => 1),
            )));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_add method
     * Process new administrator request
     *
     * @return void
     */
    public function admin_add() {
        if ($this->isAuthorized()) {
            if ($this->request->is('post')) {
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    $this->Flash->bssuccess(__('A new administrator has been added'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('New administrator could not be added. Please try again'), array('key' => 'form'));
                }
            }
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_edit method
     * Process update administrator request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if ($this->isAuthorized()) {
            if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid administrator'));
            }
            //Check if user already disabled
            if ($this->User->isDisabled($id)) {
                throw new NotFoundException(__('Administrator was deleted'));
            }
            //Only root account can change root account's information
            if ($this->Auth->user('id') != 1 && $id == 1) {
                throw new NotFoundException(__('You are not allowed to update root account'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['User']['id'] = $id; //Attach user id before save
                if ($this->User->save($this->request->data)) {
                    $this->Flash->bssuccess(__('Administrator\'s new information has been saved'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('Administrator could not be saved. Please try again'), array('key' => 'form'));
                }
            } else {
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);
            }
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->set('thisUser', $this->User->find('first', $options));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_delete method
     * Process delete admin user request
     * - Not allow remove root account
     * - Not allow remove user itself
     * - Not allow remove accounts that already marked as inactive
     * * Do not delete account, only mark the status as 0 (false)
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if ($this->isAuthorized()) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            //Prevent root from being deleted
            if ($id == 0) {
                throw new NotFoundException(__('Please do not try to remove root account'));
            }
            //Users are not allowed to delete themselves
            if ($this->Auth->user('id') == $id) {
                throw new NotFoundException(__('You cannot delete your own account'));
            }
            //Check if user already disabled
            if ($this->User->isDisabled($id)) {
                throw new NotFoundException(__('Administrator already deleted'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->User->saveField('status', 0)) {
                $this->Flash->bssuccess(__('Administrator has been deleted'));
            } else {
                $this->Flash->bsdanger(__('Administrator could not be deleted. Please try again'));
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }
}
