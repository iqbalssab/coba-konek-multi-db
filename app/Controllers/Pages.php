<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Pages extends BaseController
{
    protected $helpers = ['number'];
    public function index()
    {
        // Cara konek DB tanpa Model
        // $db = \Config\Database::connect();
        $tglsekarang = Time::now();
        $db = db_connect();
        
        $koneksi = $db->query("select * from tbmaster_user");
        
        // foreach($koneksi->getResultArray() as $konek){
            
        // }
        // dd($koneksi->getResultArray());

        $data = [
            'title' => 'Home',
            'users' => $koneksi
        ];


        
        return view('pages/home', $data);
        
    }

    public function Kasir()
    {
        $tglsekarang = Time::now();
        $tglHariIni = $tglsekarang->toDateString();

        $db = db_connect();

        $koneksiKasir = $db->query("SELECT js_cashierid AS ID_KASIR,
        username AS NAMA_KASIR,
        js_cashierstation AS KASSA, 
        js_totsalesamt AS TOTAL_TRANSAKSI, 
        js_totcashsalesamt AS TUNAI,
        js_totdebitamt AS KDEBIT,
        (js_totcc1amt+js_totcc2amt) AS KKREDIT,
        js_totcreditsalesamt AS KREDIT,
        CASE 
           WHEN js_resetamt=0 THEN 'Aktif'
           WHEN js_resetamt>0 THEN 'Closing'
         END AS Status
        FROM tbtr_jualsummary 
        LEFT JOIN tbmaster_user on js_cashierid=userid 
        WHERE trunc(js_transactiondate)=to_date('$tglHariIni','YYYY-MM-DD')
        ORDER BY status,js_cashierstation,js_cashierid");
        
        $data = [
            'title' => 'Preview Transaksi Kasir',
            'transactions' => $koneksiKasir
        ];

        

        return view('pages/about', $data);
       
    }

}
