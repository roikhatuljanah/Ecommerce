<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2 class="my-4"><?= $title; ?></h2>

            <form action="/kontak/update/<?= $kontak['id']; ?>" method="post">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Awal</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $kontak['nama']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nama1" class="form-label">Nama Akhir</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama1')) ? 'is-invalid' : ''; ?>" id="nama1" name="nama1" value="<?= (old('nama1')) ? old('nama1') : $kontak['nama1']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama1'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= (old('email')) ? old('email') : $kontak['email']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea class="form-control <?= ($validation->hasError('pesan')) ? 'is-invalid' : ''; ?>" id="pesan" name="pesan"><?= (old('pesan')) ? old('pesan') : $kontak['pesan']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('pesan'); ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/kontak" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
