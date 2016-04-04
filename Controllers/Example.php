<?php

use Puko\Core\Backdoor\Data;
use Puko\Core\Presentation\Html\View;
use Puko\Core\Presentation\Json\Service;
use Puko\Util\PukoDate;

/**
 * Class Example
 */
class Example extends Service
{
    public $id;

    function __construct($vars)
    {
        $this->id = $vars;
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
        $da = new PukoDate();

        Data::To('TanggalDetil')->Save(
            array(
                'Tanggal' => $da->NowDateTime(),
                'nama' => 'test apps'
            )
        );
    }

}