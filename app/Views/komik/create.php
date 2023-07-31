<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Tambah Data Komik</h2>

            
            <form action="/komik/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_show_error('judul')  ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>"> 
                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                            <?= validation_show_error('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_show_error('penulis')  ? 'is-invalid' : ''; ?>" id="penulis" name="penulis" <?= old('penulis'); ?>>
                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                            <?= validation_show_error('penulis'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penerbit" name="penerbit" <?= old('penerbit'); ?>>
                    </div>
                </div>
               
                    <div class="mb-3">
                        <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                        <div class="col-sm-2">
                            <img src="/img/default.png" class="img-thumbnail img-preview">
                        </div>
                        <div class="col-sm-8">
                            <div class="custom-file">
                                <input class="custom-file-input <?= validation_show_error('sampul')  ? 'is-invalid' : ''; ?>" type="file" id="sampul" name="sampul" onchange="previewImg()">
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    <?= validation_show_error('sampul'); ?>
                                </div>
                                <label for="sampul" class="custom-file-label">pilih gambar...</label>
                            </div>
                        </div>
                    </div>
                
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>