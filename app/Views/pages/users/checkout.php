<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="">
    <meta name="keywords" content="bootstrap, bootstrap4">

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/css/tiny-slider.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <title>Khat</title>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="index.html">Khat<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/Home') ?>">Home</a>
                </li>
                <li><a class="nav-link" href="<?= base_url('user/Home/shop') ?>">Shop</a></li>
                <li><a class="nav-link" href="<?= base_url('user/Home/services') ?>">Services</a></li>
                <li><a class="nav-link" href="<?= base_url('user/Home/blog') ?>">Blog</a></li>
                <li><a class="nav-link" href="<?= base_url('user/Home/contact') ?>">Kontak Kami</a></li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><a class="nav-link" href="<?= base_url('Login') ?>"><img src="/images/user.svg"></a></li>
                <li><a class="nav-link" href="<?= base_url('user/Home/cart') ?>"><img src="/images/cart.svg"></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Header/Navigation -->

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Checkout</h1>
                </div>
            </div>
            <div class="col-lg-7">
                <!-- Additional content if needed -->
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Detail Pesanan</h2>
                <form method="post" action="<?= base_url('User/Home/simpan_checkout') ?>">
                    <div class="p-3 p-lg-5 border bg-white">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="kota" class="text-black">Kota</label>
                                <input type="text" class="form-control<?= ($validation->hasError('kota')) ? ' is-invalid' : ''; ?>" id="kota" name="kota" value="<?= old('kota'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kota'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="nama" class="text-black">Nama</label>
                                <input type="text" class="form-control<?= ($validation->hasError('nama')) ? ' is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="alamat" class="text-black">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control<?= ($validation->hasError('alamat')) ? ' is-invalid' : ''; ?>" id="alamat" name="alamat" value="<?= old('alamat'); ?>" placeholder="Alamat">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('alamat'); ?>
                                </div>
                            </div>
                        </div>
                        <!-- ... (form fields for email, hp) ... -->
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email" class="text-black">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control<?= ($validation->hasError('email')) ? ' is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="hp" class="text-black">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control<?= ($validation->hasError('hp')) ? ' is-invalid' : ''; ?>" id="hp" name="hp" value="<?= old('hp'); ?>" placeholder="Phone Number">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('hp'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Pesananmu</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <table class="table site-block-order-table mb-5">
                                <!-- ... (table header) ... -->
                                <tbody>
                                    <?php
                                    $datane = $mod->getWhere('keranjang', '*', ['iduser' => session()->get('iduser')])->getResult();
                                    $subtotal = 0;
                                    $sb = 0;
                                    foreach ($datane as $d) :
                                        $pr = $mod->getWhere('produk', '*', ['id' => $d->kode_produk])->getRow();
                                        $total_produk = $pr->harga * $d->qty;
                                        $subtotal += $total_produk;
                                        $sb += $d->qty;
                                    ?>
                                        <tr>
                                            <td><?= $pr->nama ?></td>
                                            <td><?= $total_produk ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                        <td class="text-black"><?= $sb ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                        <td class="text-black font-weight-bold"><strong><?= $subtotal ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ... (additional form fields for payment method) ... -->
                            <div class="border p-3 mb-3">
                                <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Cod</a></h3>
                            </div>

                            <div class="form-group">
                                <button type="submit" onclick="PrintStruk()" class="btn btn-black btn-lg py-3 btn-block">Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>

<!-- Start Footer Section -->
<footer class="footer-section">
    <!-- ... (footer content) ... -->
</footer>
<!-- End Footer Section -->

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/tiny-slider.js"></script>
<script src="/js/custom.js"></script>
</body>
</html>
