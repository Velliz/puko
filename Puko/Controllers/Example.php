<?php
use Puko\Core\Data;
use Puko\Util\PukoDate;

/**
 * Class Example
 */
class Example
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
            //echo '<pre>';
            //var_dump($_FILES);
            //echo '</pre>';

            Data::To('filex')->Save(
                array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'file' => $_FILES['foto']['tmp_name']
                )
            );

        }
    }

    function dateinput()
    {
        $da = new PukoDate();
        var_dump($da->NowDate());
        var_dump($da->NowDateTime());

        Data::To('TanggalDetil')->Save(
            array(
                'Tanggal' => $da->NowDateTime(),
                'nama' => 'test apps'
            )
        );
    }

    function duo()
    {

    }
}