<?php
App::uses('AppController', 'Controller');

/**
 * Wikis Controller
 *
 * @property Wiki $Wiki
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class WikisController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'Flash');

    /**
     * index method
     * Display index page of wiki
     */
    public function index() {
        $this->Wiki->recursive = 0;
        //Retrieve disease data to "you may interested in" part when preference is found in session
        $favouriteIDs = $this->Session->read('Dashboard.preferredDiseases');
        if (!is_null($favouriteIDs)) {
            $favouriteOptions = array(
                'fields' => array(
                    'Wiki.id',
                    'Wiki.title',
                    'Wiki.definition',
                ),
                'conditions' => array(
                    'Wiki.vhiss_disease_id' => $favouriteIDs,
                    'Wiki.status >' => 0,
                ),
                'order' => "FIELD(vhiss_disease_id, " . implode(',', $favouriteIDs) . ")",
                'limit' => 2,
            );
            //Only fill favourite pages variable when there's something to fill
            if ($this->Wiki->find('count', $favouriteOptions) > 0)
                $this->set('favouritePages', $this->Wiki->find('all', $favouriteOptions));
        }

        //Retrieve editor's choice pages (pinned pages)
        $pinnedOptions = array(
            'fields' => array(
                'Wiki.id',
                'Wiki.title',
                'Wiki.definition',
            ),
            'conditions' => array(
                'Wiki.status' => 2,
            ),
            'order' => 'Wiki.id DESC',
            'limit' => 4,
        );
        $this->set('pinnedPages', $this->Wiki->find('all', $pinnedOptions));

        //Retrieve top viewed pages (sort by counter)
        $topViewOptions = array(
            'fields' => array(
                'Wiki.id',
                'Wiki.title',
                'Wiki.definition',
            ),
            'conditions' => array(
                'Wiki.status' => 1,
            ),
            'order' => 'Wiki.counter DESC',
            'limit' => 4
        );
        $this->set('topViewPages', $this->Wiki->find('all', $topViewOptions));
    }

    /**
     * getMoreTopViewedArticles method
     * Respond to Ajax call in wiki index page to load more top-viewed articles
     */
    public function getMoreWiki() {
        if ($this->request->is(array('post'))) {
            if (!isset($this->request->data['requestOffset']) || $this->request->data['requestOffset'] < 4) {
                throw new InvalidArgumentException("Request argument is invalid");
            }
            //Get rid of layouts, only return pure code
            $this->layout = null;
            //Retrieve top viewed pages (sort by counter) with offset
            $topViewOptions = array(
                'fields' => array(
                    'Wiki.id',
                    'Wiki.title',
                    'Wiki.definition',
                ),
                'conditions' => array(
                    'Wiki.status' => 1,
                ),
                'order' => 'Wiki.counter DESC',
                'limit' => 4,
                'offset' => $this->request->data['requestOffset']
            );
            $this->set('topViewPages', $this->Wiki->find('all', $topViewOptions));
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }

    /**
     * view method
     * Display wiki content by id
     *
     * @param int $id
     */
    public function view($id = null) {
        $this->Wiki->recursive = 0;
        if (!$this->Wiki->exists($id)) throw new NotFoundException(__('Invalid wiki page id'));
        $wikiPageOptions = array('conditions' => array('Wiki.' . $this->Wiki->primaryKey => $id));
        $wikiPage = $this->Wiki->find('first', $wikiPageOptions);
        $this->set('wiki', $wikiPage); //Send data to view for rendering
        //Check status of wiki page. If is unpublished, then throw error
        if (!isset($wikiPage['Wiki']['status']) || $wikiPage['Wiki']['status'] <= 0) {
            //Well, admin do have the right to preview unpublished page...
            if ($this->isAuthorized()) {
                $this->set('wikiPreview', true);
            } else throw new NotFoundException(__('The page you are looking for is not available'));
        }
        //Update counter of page
        $this->Wiki->updateAll(
            array('Wiki.counter' => 'Wiki.counter + 1'),
            array('Wiki.id' => $id)
        );
        //Load Announcements
        $currentDiseaseID = $this->Wiki->field('vhiss_disease_id');
        $this->loadModel('Announcement');
        $this->set('psa', $this->Announcement->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'Announcement.disease_id' => $currentDiseaseID,
                'Announcement.status' => 1,
            ),
            'order' => 'Announcement.date DESC',
            'limit' => 5
        )));
    }

    /**
     * admin_index method
     * List and filter wiki pages per request
     *
     * @param int $status
     */
    public function admin_index($status = null) {
        if ($this->isAuthorized()) {
            $this->Wiki->recursive = 0;
            $wikiSetOptions = array(
                'fields' => array(
                    'Wiki.id',
                    'Wiki.title',
                    'Wiki.vhiss_disease_id',
                    'Wiki.counter',
                    'Wiki.status',
                    'VhissDisease.value',
                ),
                'order' => array(
                    'Wiki.status' => 'desc',
                    'Wiki.title' => 'asc',
                ),
            );
            // Status of wiki: 0 is unpublished, 1 is published, 2 is pinned
            if (!is_null($status)) {
                $wikiSetOptions['conditions']['Wiki.status'] = $status;
                $this->set('currentStatus', $status);
            } else {
                $this->set('currentStatus', -1);
            }
            $this->set('wikis', $this->Wiki->find('all', $wikiSetOptions));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_updateStatus method
     * Update wiki page's status
     *
     * @param int $id
     * @param int $newStatus
     */
    public function admin_updateStatus($id = null, $newStatus = null) {
        if ($this->isAuthorized()) {
            $this->Wiki->id = $id;
            if (!$this->Wiki->exists()) {
                throw new NotFoundException(__('Invalid wiki page'));
            }
            if (!in_array((int)$newStatus, array(0, 1, 2))) {
                throw new InvalidArgumentException("Invalid argument");
            }
            $this->request->allowMethod('post', 'patch');
            if ($this->Wiki->saveField('status', $newStatus)) {
                $this->Flash->bssuccess("Status of selected wiki page is successfully changed");
            } else {
                $this->Flash->bsdanger("Status of selected wiki page cannot be changed, please try again");
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

    /**
     * admin_add method
     * Process new wiki page request
     *
     * @return void
     */
    public function admin_add() {
        if ($this->isAuthorized()) {
            if ($this->request->is('post')) {
                $this->Wiki->create();
                if ($this->Wiki->save($this->request->data)) {
                    $this->Flash->bssuccess(__('A new wiki page has been added'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('New wiki page could not be added. Please try again'), array('key' => 'form'));
                }
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Wiki->VhissDisease->find('list', array(
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
     * Process update wiki page request
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if ($this->isAuthorized()) {
            if (!$this->Wiki->exists($id)) {
                throw new NotFoundException(__('Invalid wiki page'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Wiki']['id'] = $id; //Attach wiki id before save
                if ($this->Wiki->save($this->request->data)) {
                    $this->Flash->bssuccess(__('Changes to wiki page has been saved'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->bsdanger(__('Changes to wiki page could not be saved. Please try again'), array('key' => 'form'));
                }
            } else {
                $options = array('conditions' => array('Wiki.' . $this->Wiki->primaryKey => $id));
                $this->request->data = $this->Wiki->find('first', $options);
            }
            //List of diseases for inline selector
            $this->set('listDiseases', $this->Wiki->VhissDisease->find('list', array(
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
     * Delete wiki page by given id
     *
     * @param int $id
     */
    public function admin_delete($id = null) {
        if ($this->isAuthorized()) {
            $this->Wiki->id = $id;
            if (!$this->Wiki->exists()) {
                throw new NotFoundException(__('Requested ID not exist'));
            }
            if ($this->request->is(array('post', 'delete'))) {
                if ($this->Wiki->delete()) {
                    $this->Flash->bssuccess(__('Requested wiki page has been deleted.'));
                } else {
                    $this->Flash->bsdanger(__('Requested wiki page cannot be deleted. Please try again'), array('key' => 'form'));
                }
            } else {
                throw new BadRequestException('Invalid request type');
            }
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->bswarning(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }

}