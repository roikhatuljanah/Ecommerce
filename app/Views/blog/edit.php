<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>



<!-- Form tambah data -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-fw  fa-user-circle"></i> Form Edit Data Blog</h6>
    </div>
    <div class="card-body">

        <form action="/blog/update/<?= $blog['id']; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $blog['id']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $blog['gambar']; ?>">

            <!-- <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" autofocus value="<?= old('nama'); ?>">
                <div class=" invalid-feedback">
                <?= $validation->getError('nama'); ?>
                </div>
            </div> -->


            <div class="form-group">
                <label for="nama">Judul </label>
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= $blog['nama']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="pembuat">Pembuat </label>
                <input type="text" class="form-control <?= ($validation->hasError('pembuat')) ? 'is-invalid' : ''; ?>" id="pembuat" name="pembuat" autofocus value="<?= $blog['pembuat']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('pembuat'); ?>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="tanggal">Tanggal </label>
                <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" id="tanggal" name="tanggal" autofocus value="<?= $blog['tanggal']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal'); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-5">
                    <img class="img-thumbnail" src="/images/blog/<?= $blog['gambar']; ?>" height="20px">
                </div>
            </div>

            <div class="custom-file mb-3">
                <div class="col-sm-6">
                    <input type="file" class="form-control custom-file-input <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" autofocus value="<?= old('gambar'); ?>" id="gambar" name="gambar">
                    <label class="custom-file-label" for="validatedCustomFile">Pilih Gambar...</label>
                    <div class="invalid-feedback"> <?= $validation->getError('gambar'); ?></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Submit</button>

            <a href="/blog" class="btn btn-success"><i class="fas fa-undo"></i> Back</a>

        </form>
    </div>
</div>





<?= $this->endSection(); ?>