<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <title>Update | pride</title>

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/default.min.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/gen2eral.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/pages/update.css') ?>">
</head>

<body>
    <header>
        <div class="container">
            <h1 class="page-title">pride Update</h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col">
                <?php if (vars('success')): ?>
                    <div class="jumbotron">
                        <h1 class="display-4">Success!</h1>
                        <p class="lead">
                            The database got updated successfully.
                        </p>
                        <hr class="my-4">
                        <p>
                            You can now use the latest pride version.
                        </p>
                        <a href="<?= site_url('login') ?>" class="btn btn-success btn-large">
                            <i class="fas fa-wrench me-2"></i>
                            <?= lang('backend_section') ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="jumbotron">
                        <h1 class="display-4">Failure!</h1>
                        <p class="lead">
                            There was an error during the update process.
                        </p>
                        <hr class="my-4">
                        <p>
                            Please restore your database backup.
                        </p>
                        <a href="<?= site_url('login') ?>" class="btn btn-success btn-large">
                            <i class="fas fa-wrench me-2"></i>
                            <?= lang('backend_section') ?>
                        </a>

                        <p>
                            Please restore your database backup.
                        </p>
                    </div>

                    <div class="well text-start">
                        Error Message:
                        <?= vars('exception') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <a href="https://pride.osiloke.com">pride</a>
    </footer>

    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/fontawesome.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/solid.min.js') ?>"></script>
</body>

</html>