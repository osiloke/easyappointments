<!doctype html>
<html lang="<?= config('language_code') ?>" class="bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#F3F5F6">
    <meta name="google" content="notranslate">

    <?php slot('meta') ?>

    <title>
        Book with
        <?= vars('page_title') ?>
    </title>
    <!-- Primary Meta Tags -->
    <title>Schedl.me</title>
    <meta name="title" content="Schedl.me" />
    <meta name="description"
        content="A scheduling automation platform for consultation & appointment bookings that allows Nigerian service providers to receive payments.(Basically, something as simple as cal.com but focusing on payment integration features to accommodate PayStack, Flutterwave, and other API-friendly payment providers)" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:title" content="Schedl.me" />
    <meta property="og:description"
        content="A scheduling automation platform for consultation & appointment bookings that allows Nigerian service providers to receive payments.(Basically, something as simple as cal.com but focusing on payment integration features to accommodate PayStack, Flutterwave, and other API-friendly payment providers)" />
    <meta property="og:image" content="<?= asset_url('assets/img/landing/screenshot.jpg') ?>" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= current_url() ?>" />
    <meta property="twitter:title" content="Schedl.me" />
    <meta property="twitter:description"
        content="A scheduling automation platform for consultation & appointment bookings that allows Nigerian service providers to receive payments.(Basically, something as simple as cal.com but focusing on payment integration features to accommodate PayStack, Flutterwave, and other API-friendly payment providers)" />
    <meta property="twitter:image" content="<?= asset_url('assets/img/landing/screenshot.jpg') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset_url('assets/img/site.webmanifest') ?>">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/cookieconsent/cookieconsent.min.css') ?>">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/landing_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => vars('company_color')]) ?>

    <?php slot('styles') ?>
</head>

<body data-theme="lofi" class="bg-gray-100">

    <?php slot('content') ?>

    <?php component('js_vars_script') ?>
    <?php component('js_lang_script') ?>

    <?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]) ?>
    <?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url')]) ?>

    <?php slot('scripts') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>
    <script>
        AOS.init({
            delay: 200, // values from 0 to 3000, with step 50ms
            duration: 1000, // values from 0 to 3000, with step 50ms
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
        });
    </script>

</body>

</html>