<?php

use Puko\Core\Auth\Authentication;
use Puko\Core\Backdoor\Data;
use Puko\Core\Presentation\Html\View;

/**
 * Class Example
 */
class Example extends View
{

    private $id;

    function __construct($vars, $authCode)
    {
        parent::__construct($authCode);
        $this->id = $vars;
        $this->PukoAuthObject = Authentication::GetInstance($authCode);
    }

    function main()
    {
        return array(
            'PageTitle' => 'Puko Framework',
            'Welcome' => 'Welcome To Puko Framework Test Programs',
        );
    }

    function fileupload()
    {

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

        return array('om' => '23123', 'adik' => 'asd');
    }

    function dateinput()
    {
        $da = new \Puko\Util\DateTime();

        Data::To('TanggalDetil')->Save(
            array(
                'Tanggal' => $da->NowDateTime(),
                'nama' => 'test apps'
            )
        );
    }

}