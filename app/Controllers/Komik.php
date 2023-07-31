<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    protected $helpers = ['form'];
    
    
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    // ==================== INDEX ==============================
    // ======== MENAMPILKAN SEMUA DATA YANG DI QUERY ===========
    public function index()
    {
        // dimatikan karena sudah dipanggil di Method
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        // Cara konek DB tanpa Model
        // $db = \Config\Database::connect();
        // $komik = $db->query('select * from komik');
        // foreach($komik->getResultArray() as $row){
        //     d($row);
        // }

        // Manggil namespace Model nya KomikModel
        // $komikModel = new \App\Models\KomikModel();
        

        return view('komik/index', $data);
    }

    // ========== CREATE =================================
    // ========== TAMPILKAN HALAMAN TAMBAH DATA BARU =====
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Komik'
        ];

        return view('komik/create', $data);

    }

    // =========== DETAIL ===================================
    // ======== QUERY SELURUH ISI DARI 1 KOLOM TABLE. DAN TAMPILKAN DI HALAMAN DETAIL ======== 
    public function detail($slug)
    {
        
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak ada di table
        if(empty($data['komik'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik '.$slug.' tidak ditemukan');
        }

        return view('komik/detail', $data);
    }

    // ====== SAVE ===========================
    //  ======= MENYIMPAN DATA YANG DIISI, DENGAN MENENTUKAN RULES VALIDASINYA =========
    // ========= REDIRECT KEMBALI DENGAN MEMBAWA SESSION withInput() ===================
    public function save()
    {
        // seperti nama variabelnya, aturan untuk validasi data
        $rules = [
            'judul' => 'required|is_unique[komik.judul]',
            'penulis' => 'required',
            'sampul' => [
                'rules' => 'max_size[sampul,1500]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [

                    'max_size' => 'ukuran gambar terlalu besar!',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ];
        // validasi input, kalo salah
        if(!$this->validate($rules)){            
            // kembali ke halaman tambah data
            return redirect()->to('/komik/create')->withInput();
        }

        // ambil gambar yang diupload, masukin ke komputer kita
        $fileSampul = $this->request->getFile('sampul');
        
        // cek, apakah tidak ada gambar yang diupload
        // getError() mengembalikan data int antara 0 sampai 4. masing2 punya keterangan sendiri
        if($fileSampul->getError() == 4){
            // pake gambar default
            $namaSampul = 'default.png';
        } else{
            // kalo ada gambar sampul yang diinput
            // Generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();
    
            // pindahkan file ke folder img
            // move('lokasi folder', variabel yg berisi nama sampul random)
            $fileSampul->move('img', $namaSampul);
        }


        // mengubah spasi judul jadi '-', dan lowercase semua huruf
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // isi data yg diinput ke dalam database pake function save()
        // $this->request->getVar() untuk mengambil isi dari apa yg diinputkan
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        // buat flashdata, masukan ke dalam session.
        // tulis pesannya ('key value', 'isi pesan')
        session()->setFlashdata('pesan','Data berhasil ditambahkan!');

        // arahkan ke halaman komik
        return redirect()->to('/komik');
    }

    // =========== DELETE ======================================
    // ============== MENGHAPUS DATA, SEKALIAN GAMBARNYA ==========
    public function delete($id)
    {
        // cari gambar berdasarkan $id
        // query ke model komikModel
        $komik = $this->komikModel->find($id);

        // cek jika file gambarnya default.png
        if($komik['sampul'] != 'default.png'){
            // hapus gambar dari folder
            unlink('img/'. $komik['sampul']);
        }

        // query delete lewat model komikModel berdasarkan $id
        $this->komikModel->delete($id);

        // buat flashData, masukin ke dalam session
        session()->setFlashdata('pesan', 'Berhasil Hapus Data!');
        // arahkan ke halaman komik
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul 
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if($komikLama['judul'] == $this->request->getVar('judul')){
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        $rules = [
            'judul' => $rule_judul,
            'penulis' => 'required',
            'sampul' => [
                'rules' => 'max_size[sampul,1500]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [

                    'max_size' => 'ukuran gambar terlalu besar!',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ];
        // validasi input
        if(!$this->validate($rules)){
           
            return redirect()->to('/komik/edit/'.$this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah sama apa engga
        if($fileSampul->getError() == 4){
            $namaSampul = $this->request->getVar('sampulLama');
        } else{
            // generate nama Random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan ke folder public/img
            $fileSampul->move('img', $namaSampul);
            // hapus file yg lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

    
        // mengubah spasi judul jadi '-', dan lowercase semua huruf
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // isi data yg diinput ke dalam database
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);

        session()->setFlashdata('pesan','Data berhasil diubah!');

        return redirect()->to('/komik');
    }
   
}
?>