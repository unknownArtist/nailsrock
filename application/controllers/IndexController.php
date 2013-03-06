<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {


    }

    public function indexAction()
    {
        if (My_Auth::getInstance()->isLoggedIn())
        {


            $this->_redirect('/appointments/index');
        } else
        {

        }
        $form = new Application_Form_Login();
        $this->view->AdminSignIn = $form;


        $authAdapter = $this->getAuthAdapter();

        if ($this->getRequest()->isPost())
        {

            $formData = $this->getRequest()->getPost();


            if ($form->isValid($formData))
            {
                $admin = $form->getValue('userName');
                $password = $form->getValue('password');

             
                $authAdapter->setIdentity($admin)->setCredential($password);

                $auth = Zend_Auth::getInstance();


                //
                $result = $auth->authenticate($authAdapter);


                if ($result->isValid())
                {


// $s = new Zend_Session_Namespace(
//     $auth->getStorage()->getNamespace() );

// $s->setExpirationSeconds( 24*60*60 );
                    $this->_redirect('home');
                } else
                {
                    $form->populate($formData);
                    $this->view->SignUpError = "Invalid Username or Password";
                }

            } else
            {
                $form->populate($formData);
            }
        }
    }

    private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('adminlogin')->setIdentityColumn('adminUsername')->
            setCredentialColumn('adminPasword');

        return $auth;
    }


    public function createAction()
    {


    }

    public function logoutAction()
    {


        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('http://nailsrock.biz/default.html');
    }

}
