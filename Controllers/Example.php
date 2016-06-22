<?php

use Puko\Core\Presentation\View;
use Puko\Util\DateAndTime;

/**
 * Class Example
 * #Value PageTitle Welcome To Puko
 */
class Example extends View
{

    private $id;

    function __construct($vars)
    {
        parent::__construct();
        $this->id = $vars;
    }

    function Main()
    {
        if (!$this->PukoAuthObject->IsAuthenticated()) {
            return array(
                'PageTitle' => 'Puko Framework',
                'Welcome' => 'Welcome To Puko Framework NOT AUTHENTICATED',
            );
        } else {
            return array(
                'PageTitle' => 'Puko Framework',
                'Welcome' => 'AUTHENTICATED',
            );
        }
    }

    /**
     * #Value PageTitle Login ke Aplikasi
     */
    function Login()
    {
        $this->PukoAuthObject->Authenticate('d', 'v');
    }

    function Logout()
    {
        $this->PukoAuthObject->RemoveAuthentication();
        $this->RedirectTo('fileupload');
    }

    function add(){
        $this->PukoAuthObject->setSessionData('velliz', 'koplax');
    }

    function rem(){
        $this->PukoAuthObject->removeSessionData('velliz');
    }

    /**
     * #Value PageTitle Upload File Anda
     */
    function FileUpload()
    {
        $vars = array();
        $vars['PageTitle'] = 'Upload File';

        $dataSubmit = isset($_POST['_submit']);
        return $vars;
    }

    function DateInput()
    {
        $da = new DateAndTime();
    }

    function NoAccess()
    {
        echo 'koplax login aja salah';
    }

}