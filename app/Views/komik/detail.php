
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row mt-2">
        <div class="col">
            <h2 class="mt-2">Detail Komik </h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text">Penulis : <b><?= $komik['penulis']; ?></b> </p>
                            <p class="card-text"><small class="text-body-secondary">Penerbit : <b><?= $komik['penerbit']; ?></b> </small></p>

                            <a href="/komik/edit/<?= $komik['slug'];?>" class="btn btn-warning ">Edit</a>

                            <!-- tombol hapus -->
                            <form action="/komik/<?= $komik['id']; ?>" class="d-inline" method="post">
                            <?= csrf_field(); ?>
                            <!-- http spoofing -->
                            <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="confirm('Yakin Hapus?');">Delete</button>
                            </form>
                            <br><br>  

                            <a href="/komik">Kembali ke Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>