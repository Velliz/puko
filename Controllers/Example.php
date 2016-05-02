<?php

use Puko\Core\Backdoor\Data;
use Puko\Core\Presentation\Json\Service;
use Puko\Util\DateAndTime;

/**
 * Class Example
 */
class Example extends \Puko\Core\Presentation\Html\View
{

    private $id;

    function __construct($vars)
    {
        parent::__construct();
        $this->id = $vars;
    }

    function Main()
    {
        if(!$this->PukoAuthObject->IsAuthenticated()) {
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

    function Login(){
        $this->PukoAuthObject->Authenticate('d', 'v');
    }

    function FileUpload()
    {
        $vars = array();
        $vars['PageTitle'] = 'Upload File';

        $dataSubmit = isset($_POST['_submit']);
        if ($dataSubmit) {
            Data::To('filex')->Save(
                array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'file' => $_FILES['foto']['tmp_name']
                )
            );
        }
        return $vars;
    }

    function dateinput()
    {
        $da = new DateAndTime();

        Data::To('TanggalDetil')->Save(
            array(
                'Tanggal' => $da->NowDateTime(),
                'nama' => 'test apps'
            )
        );
    }

}