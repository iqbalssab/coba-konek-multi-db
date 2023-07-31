<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komik';
    protected $useTimeStamps = true;
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];

    public function getKomik($slug = false)
    {
        // kalo slug nya ga ada
        if($slug == false) {

            // SELECT * FROM komik;
            return $this->findAll();
        }

        // select * from komik where slug = $slug. ambil data pertama
        return $this->where(['slug' => $slug])->first();
    }
}