<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Form tambah data -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-fw  fa-user-circle"></i> Form Tambah Data produk</h6>
    </div>
    <div class="card-body">
        <form action="/produk/simpan" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= old('nama'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama'); ?>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" id="deskripsi" name="deskripsi" autofocus value="<?= old('deskripsi'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('deskripsi'); ?>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="harga">Harga</label>
                <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" autofocus value="<?= old('harga'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('harga'); ?>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="stok">Stok</label>
                <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" id="stok" name="stok" autofocus value="<?= old('stok'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('stok'); ?>
                </div>
            </div>
            <div class="custom-file mb-3">
                <input type="file" class="form-control custom-file-input <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" autofocus value="<?= old('gambar'); ?>" id="gambar" name="gambar">
                <label class="custom-file-label" for="validatedCustomFile">Pilih Gambar...</label>
                <div class="invalid-feedback"> <?= $validation->getError('gambar'); ?></div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Submit</button>

            <a href="/produk" class="btn btn-success"><i class="fas fa-undo"></i> Back</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
