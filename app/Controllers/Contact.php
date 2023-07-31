<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contact',
            'alamat' => 
            [ 
                [
                'nama' => 'ojak',
                'alamat' => 'pasir wetan',
                'kota' => 'purwokerto'
                ],
                [
                'nama' => 'rizky',
                'alamat' => 'bancarkembar kulon',
                'kota' => 'bogor'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }

}
