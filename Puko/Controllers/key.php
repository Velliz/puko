<?php

use Puko\Core\Data;

class key
{

    var $id;

    function __construct($vars)
    {
        $this->id = $vars;
    }

    function key(){}

    function main()
    {
        //$hasil['Person'] = Data::From("select * from person")->FetchAll();
        $hasil['Person'] = array(
                array('Nama' => 'Test 1'),
                array('Alamat' => 'Test 2')

        );
        $hasil['PageTitle'] = 'Test';
        return $hasil;
    }

    function simpanacara()
    {

        return array(
            'Pemesan' => 'Dwi Paulina',
            'Deskripsi' => 'sdasdasdas'
        );

    }

    function pertama($pesan = null, $duas = null)
    {
        $data = array(
            'Nama' => 'Dddddddididt Velliz 2xxxxx',
            'Alamat' => 'Jalan Surya Sumantri No 75',
            'Keterangan' => 'Smart Update',
            'Umur' => 22,
        );

        $where = array(
            'ID' => 1,
        );

//        Data::To("test")->Update($where, $data);
//        Data::To("test")->Save($data);
    }
}