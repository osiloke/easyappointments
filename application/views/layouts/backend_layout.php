<!doctype html>
<html lang="<?= config('language_code') ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#35A768">
    <meta name="google" content="notranslate">

    <?php slot('meta'); ?>

    <title>
        <?= vars('page_title') ?? lang('backend_section') ?>
    </title>

    <link rel="apple-icon" type="image/png" sizes="57x57" href="<?= asset_url('assets/img/apple-icon-57x57.png') ?>">
    <link rel="apple-icon" type="image/png" sizes="60x60" href="<?= asset_url('assets/img/apple-icon-60x60.png') ?>">
    <link rel="apple-icon" type="image/png" sizes="72x72" href="<?= asset_url('assets/img/apple-icon-72x72.png') ?>">
    <link rel="apple-icon" type="image/png" sizes="76x76" href="<?= asset_url('assets/img/apple-icon-76x76.png') ?>">
    <link rel="apple-icon" type="image/png" sizes="120x120"
        href="<?= asset_url('assets/img/apple-icon-120x120.png') ?>">
    <link rel="apple-icon" type="image/png" sizes="152x152"
        href="<?= asset_url('assets/img/apple-icon-152x152.png') ?>">
    <link rel="apple-icon" sizes="180x180" href="<?= asset_url('assets/img/apple-icon-180x180.png') ?>">
    <link rel="apple-icon" sizes="192x192" href="<?= asset_url('assets/img/apple-icon-192x192.png') ?>">
    <link rel="manifest" href="<?= asset_url('assets/img/site.webmanifest') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_url('assets/img/favicon-16x16.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= asset_url('assets/img/favicon-96x96.png') ?>">
    <link rel="ms-icon" type="image/png" sizes="70x70" href="<?= asset_url('assets/img/ms-icon-70x70.png') ?>">
    <link rel="ms-icon" type="image/png" sizes="144x144" href="<?= asset_url('assets/img/ms-icon-144x144.png') ?>">
    <link rel="ms-icon" type="image/png" sizes="150x150" href="<?= asset_url('assets/img/ms-icon-150x150.png') ?>">
    <link rel="ms-icon" type="image/png" sizes="310x310" href="<?= asset_url('assets/img/ms-icon-310x310.png') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/favicon.png') ?>">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/trumbowyg/trumbowyg.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/select2/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/flatpickr.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/material_green.min.css') ?>">
    <link rel="stylesheet" type="text/css"
        href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/backend_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => setting('company_color')]); ?>

    <?php slot('styles'); ?>
</head>

<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0">

        <?php component('backend_header', ['active_menu' => vars('active_menu')]); ?>

        <?php slot('content'); ?>

    </main>

    <?php component('backend_footer', ['user_display_name' => vars('user_display_name')]); ?>

    <script src="<?= asset_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@popperjs-core/popper.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/bootstrap/bootstrap.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/moment-timezone/moment-timezone-with-data.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/fontawesome.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/solid.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/tippy.js/tippy-bundle.umd.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/trumbowyg/trumbowyg.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/select2/select2.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/flatpickr/flatpickr.min.js') ?>"></script>

    <script src="<?= asset_url('assets/js/app.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/date.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/file.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/http.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/lang.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/string.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
    <script src="<?= asset_url('assets/js/layouts/backend_layout.js') ?>"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>"></script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>

</body>

</html>