<?= $this->include('layout/header'); ?>
<?= $this->include('layout/topbar'); ?>
<?= $this->include('layout/sidebar'); ?>

<div class="content-wrapper">
<?= $this->renderSection('content'); ?>
</div>
<?= $this->include('layout/footer'); ?>

<?= $this->include('layout/script'); ?>
