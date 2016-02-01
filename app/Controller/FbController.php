<?php
App::uses('Controller', 'Controller');
App::import('Vendor', 'Facebook', array('file' => 'Facebook/facebook.php'));

class FbController extends AppController {

    public $components = array('Session', 'Flash');

    //In-scope variables
    private $baseURL, $fbObject;

    /**
     * This function is overriding system function that allow some procedures run before running actions
     */
    public function beforeFilter() {
        //Initialize Facebook API credentials and SDK objects
        $this->baseURL = Router::url('/', true);

        Configure::load('facebook');
        if (Configure::read('debug') <= 0) {
            $fbAppID = Configure::read('Facebookproduction.appId');
            $fbAppSecret = Configure::read('Facebookproduction.secret');
        } else {
            $fbAppID = Configure::read('Facebooktest.appId');
            $fbAppSecret = Configure::read('Facebooktest.secret');
        }
        $this->fbObject = new Facebook(array(
            'appId' => $fbAppID,
            'secret' => $fbAppSecret,
        ));

        //Disable layout in this controller's views and not to render a view since no need one
        $this->layout = false;
        $this->render(false);

        parent::beforeFilter();
    }

    /**
     * login Method
     * Create and redirect user to Facebook login page
     */
    public function login() {
        //Record origin URL
        $this->Session->write('fbOriginURL', $this->request->referer());
        //Get login URL
        $loginURL = $this->fbObject->getLoginUrl(array(
            'redirect_uri' => $this->baseURL . 'fb/login_callback',
            'display' => 'page'
        ));
        //Then redirect user to login page
        $this->redirect($loginURL);
    }

    /**
     * login_callback Method
     * Process received login callback request
     */
    public function login_callback() {
        $fbCallback = $this->fbObject->getUser();
        //Check callback data
        if ($fbCallback) {
            try {
                //Retrieve user data
                $user_profile = $this->fbObject->api('/me');
                //Generate logout link
                $params = array('next' => $this->baseURL . 'fb/logout_callback');
                $logout = $this->fbObject->getLogoutUrl($params);
                //Write those info into session
                $this->Session->write('fbUser', $user_profile);
                $this->Session->write('fbLogout', $logout);
            } catch (FacebookApiException $e) {
                $this->Flash->frontwarning('Your Facebook user data cannot be retrieved. Please try to login again');
            }
            //When login is successful
            $this->Flash->frontsuccess('Welcome, ' . $user_profile['name']);
        } else {
            //When login is not successful
            $this->Flash->frontwarning('Your Facebook login is not successful. Please try to login again');
        }
        //Redirect back to posts homepage
        $redirectURL = $this->Session->read('fbOriginURL');
        $this->Session->delete('fbOriginURL');
        $this->redirect($redirectURL);
    }

    /**
     * logout Method
     * Send user to Facebook page to logout
     */
    public function logout() {
        //Record origin URL
        $this->Session->write('fbOriginURL', $this->request->referer());

        $logoutURL = $this->Session->read('fbLogout');
        if (!empty($logoutURL)) {
            $this->redirect($logoutURL);
        } else {
            $this->Session->delete('fbOriginURL');
            $this->Session->delete('fbUser');
            $this->Session->delete('fbLogout');
            $this->redirect($this->request->referer());
        }
    }

    /**
     * logout_callback Method
     * Destroy users' login session
     */
    public function logout_callback() {
        //Remove user from session
        $this->Session->delete('fbUser');
        $this->Session->delete('fbLogout');
        $this->Flash->frontinfo('You are successfully logged out');

        //Redirect back to posts homepage
        $redirectURL = $this->Session->read('fbOriginURL');
        $this->Session->delete('fbOriginURL');
        $this->redirect($redirectURL);
    }

    public function fbLoginTest() {
        if ($this->isAuthorized()) {
            $ses_user = $this->Session->read('fbUser');
            $logoutURL = $this->Session->read('fbLogout');
            if ($this->Session->check('fbUser') && !empty($ses_user)) {
                echo '<img src="https://graph.facebook.com/' . $ses_user['id'] . '/picture" /><br />' . $ses_user['name'];
                echo '<br /><a href="' . $logoutURL . 'fb/login' . '">Logout</a>';
            } else {
                echo '<a href="' . $this->baseURL . 'fb/login' . '">Login</a>';
            }
        } else {
            $this->Flash->set(__('You do not have permission to do this'));
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));
        }
    }
}
