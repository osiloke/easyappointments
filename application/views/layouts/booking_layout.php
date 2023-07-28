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
        <?= lang('page_title') . ' ' . vars('provider_data')['first_name'] . ' ' . vars('provider_data')['last_name'] ?>
    </title>
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

    <!-- Meta Tags Generated with https://metatags.io -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset_url('assets/img/site.webmanifest') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset_url('assets/img/site.webmanifest') ?>">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/cookieconsent/cookieconsent.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/flatpickr.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/material_green.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . vars('theme') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/layouts/booking_layout.css') ?>">

    <?php component('company_color_style', ['company_color' => vars('company_color')]) ?>

    <?php slot('styles') ?>
</head>

<body data-theme="lofi" class="bg-gray-100">
    <div id="main" class="container">
        <?php component('navbar', ['company_color' => vars('company_color')]) ?>
        <div class="row wrapper">

            <div id="book-appointment-wizard" class="bg-transparent shadow-none">

                <?php component('booking_header', ['company_name' => vars('company_name'), 'company_logo' => vars('company_logo')]) ?>

                <?php slot('content') ?>

                <?php component('booking_footer', ['display_login_button' => vars('display_login_button')]) ?>

            </div>
        </div>
    </div>

    <?php if (vars('display_cookie_notice') === '1'): ?>
        <?php component('cookie_notice_modal', ['cookie_notice_content' => vars('cookie_notice_content')]) ?>
    <?php endif ?>

    <?php if (vars('display_terms_and_conditions') === '1'): ?>
        <?php component('terms_and_conditions_modal', ['terms_and_conditions_content' => vars('terms_and_conditions_content')]) ?>
    <?php endif ?>

    <?php if (vars('display_privacy_policy') === '1'): ?>
        <?php component('privacy_policy_modal', ['privacy_policy_content' => vars('privacy_policy_content')]) ?>
    <?php endif ?>

    <script src="<?= asset_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/cookieconsent/cookieconsent.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@popperjs-core/popper.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/bootstrap/bootstrap.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/moment-timezone/moment-timezone-with-data.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/fontawesome.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/solid.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/tippy.js/tippy-bundle.umd.min.js') ?>"></script>
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
    <script src="<?= asset_url('assets/js/layouts/booking_layout.js') ?>"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>"></script>

    <?php component('js_vars_script') ?>
    <?php component('js_lang_script') ?>

    <?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]) ?>
    <?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url')]) ?>

    <?php slot('scripts') ?>

</body>

</html>
