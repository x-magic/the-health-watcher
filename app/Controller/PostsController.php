<?php
App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class PostsController extends AppController {

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
     * List categories in discussion forum
     */
    public function index() {
        //Get a list of diseases, this is used as category names
        $this->set('diseaseList', $this->Post->VhissDisease->find('list', array(
            'fields' => array(
                'VhissDisease.id',
                'VhissDisease.value'
            ),
            'order' => 'VhissDisease.value ASC'
        )));
        //Get list of number of threads in each category
        //This involves creating a virtualField on the fly (since add it directly to Model will likely break other functions)
        $this->Post->virtualFields['thread_count'] = 'COUNT(Post.id)';
        $countOptions = array(
            'fields' => array(
                'Post.disease_id',
                //That virtual field goes here
                'Post.thread_count',
            ),
            'conditions' => array(
                'Post.status' => 1,
                'Post.parent_id' => null,
            ),
            'group' => array( 'Post.disease_id' ),
        );
        $this->set('countList', $this->Post->find('list', $countOptions));
    }

    /**
     * category method
     * List threads that in a specific category
     * @param int $id
     */
    public function category($id = null) {
        //Check if thread exists
        if (!$this->Post->VhissDisease->exists($id)) {
            throw new NotFoundException(__('This category is not exist'));
        }

        //Render page with threads
        $this->set('threads', $this->Post->find('all', array(
            'fields' => array(
                'Post.id',
                'Post.title',
                'Post.time',
                'Post.username',
            ),
            'conditions' => array(
                'Post.disease_id' => $id,
                'Post.parent_id' => null,
                'Post.status' => 1,
            ),
            'order' => 'Post.id DESC',
            'limit' => 10,
            'recursive' => 0,
        )));
        //And information of that disease
        $this->set('disease', $this->Post->VhissDisease->find('first', array('conditions' => array('VhissDisease.id' => $id))));

        //Session and login stuff
        $this->set('isAuthorized', $this->isAuthorized());
    }

    /**
     * ajaxcategory method
     * Retrieve more threads by given category id
     */
    public function ajaxcategory() {
        if ($this->request->is(array('post'))) {
            if (!isset($this->request->data['requestCategory']) || !isset($this->request->data['requestOffset']) || $this->request->data['requestOffset'] < 10) {
                throw new InvalidArgumentException("Request argument is invalid");
            }
            $categoryID = $this->request->data['requestCategory'];
            //Check if thread exists
            if (!$this->Post->VhissDisease->exists($categoryID)) {
                throw new NotFoundException(__('Category ID is not exist'));
            }
            //Get rid of layouts, only return pure code
            $this->layout = null;
            //Retrieve threads with offset
            $options = array(
                'fields' => array(
                    'Post.id',
                    'Post.title',
                    'Post.time',
                    'Post.username',
                ),
                'conditions' => array(
                    'Post.disease_id' => $categoryID,
                    'Post.parent_id' => null,
                    'Post.status' => 1,
                ),
                'order' => 'Post.id DESC',
                'limit' => 10,
                'recursive' => 0,
                'offset' => $this->request->data['requestOffset']
            );
            $this->set('ajaxThreads', $this->Post->find('all', $options));
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }

    /**
     * thread method
     * Retrieve single discussion thread and its child threads
     *
     * @var int $id
     */
    public function thread($id = null) {
        //Check if thread exists
        if (!$this->Post->exists($id)) {
            throw new NotFoundException(__('This post is not exist'));
        }
        //Check if thread is a master thread (not a child) and not removed
        if(!$this->Post->isValudParentThread($id)) {
            throw new InvalidArgumentException(__('This post ID is not valid'));
        }
        //Retrieve requested thread
        $this->Post->recursive = 0;
        //Main Thread
        $options = array(
            'conditions' => array(
                'Post.id' => $id,
                'Post.parent_id' => null,
                'Post.status' => 1,
            ),
        );
        $this->set('threads', $this->Post->find('first', $options));

        //Child Thread
        $childOptions = array(
            'conditions' => array(
                'Post.parent_id' => $id,
                'Post.status' => 1,
            ),
            'limit' => 4,
        );
        $this->set('subThreads', $this->Post->find('all', $childOptions));

        //Session and login stuff
        $this->set('isAuthorized', $this->isAuthorized());
    }

    /**
     * ajaxposts method
     * Retrieve more post of given thread id
     */
    public function ajaxposts() {
        if ($this->request->is(array('post'))) {
            if (!isset($this->request->data['requestParent']) || !isset($this->request->data['requestOffset']) || $this->request->data['requestOffset'] < 4) {
                throw new InvalidArgumentException("Request argument is invalid");
            }
            $parentID = $this->request->data['requestParent'];
            //Check if thread exists
            if (!$this->Post->exists($parentID)) {
                throw new NotFoundException(__('Post ID is not exist'));
            }
            //Get rid of layouts, only return pure code
            $this->layout = null;
            //Retrieve posts with offset
            $options = array(
                'conditions' => array(
                    'Post.parent_id' => $parentID,
                    'Post.status' => 1,
                ),
                'limit' => 5,
                'offset' => $this->request->data['requestOffset']
            );
            $this->set('ajaxPosts', $this->Post->find('all', $options));
            $this->set('isAuthorized', $this->isAuthorized());
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }

    /**
     * addpost method
     * Allow user who logged in to post reply (or new post)
     */
    public function addpost() {
        $originURL = $this->request->referer();
        if ($this->request->is(array('post'))) {
            //Check if user is logged in (by Facebook)
            $fbUser = $this->Session->read('fbUser');
            if (!$this->Session->check('fbUser') && empty($fbUser)) {
                $this->Flash->frontwarning('Your login session may be expired. Please login before sending reply');
                $this->redirect($originURL);
            } else {
                //Get user's session information and append it to request
                $this->request->data['Post']['userid'] = $fbUser['id'];
                $this->request->data['Post']['username'] = $fbUser['name'];
                //Only master post have titles
                if (isset($this->request->data['Post']['parent_id'])) unset($this->request->data['Post']['title']);
                $this->Post->create();
                if ($this->Post->save($this->request->data)) {
                    $this->Flash->frontsuccess(__('Your post has been submitted'));
                } else {
                    $this->Flash->frontwarning(__('Your post cannot be submitted, please try again'));
                }
                return $this->redirect($originURL);
            }
            return $this->redirect('/');
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }

    /**
     * removepost method
     * Allow administrator or owner of post remove their post
     *
     * @param int $id
     */
    public function removepost($id = null) {
        if ($this->request->is(array('post'))) {
            //Assign and check if post is valid
            $this->Post->id = $id;
            if (!$this->Post->exists()) {
                throw new NotFoundException(__('Post does not exist'));
            }
            //Determine return path
            if ($this->Post->field('parent_id') == null) {
                $returnPath = array('action' => 'category', $this->Post->field('disease_id'));
            } else {
                $returnPath = $this->request->referer();
            }
            if ($this->isAuthorized()) {
                //Administrator can delete any post
                if ($this->Post->saveField('status', 0)) {
                    $this->Flash->frontsuccess(__('Selected post has been removed'));
                } else {
                    $this->Flash->frontwarning(__('Post could not be removed. Please try again'));
                }
            } else {
                //Check if user is logged in (by Facebook)
                $fbUser = $this->Session->read('fbUser');
                if ($this->Session->check('fbUser') && !empty($fbUser)) {
                    $createrID = $this->Post->field('userid');
                    //User only allow to remove their own post
                    if ($createrID == $fbUser['id']) {
                        if ($this->Post->saveField('status', 0)) {
                            $this->Flash->frontsuccess(__('Selected post has been removed'));
                        } else {
                            $this->Flash->frontwarning(__('Post could not be removed. Please try again'));
                        }
                    } else {
                        $this->Flash->frontwarning('You cannot remove posts from other user');
                    }
                } else {
                    $this->Flash->frontwarning('Your login session may be expired. Please login before sending reply');
                }
            }
            $this->redirect($returnPath);
        } else {
            throw new BadRequestException('Request method not allowed');
        }
    }
}
