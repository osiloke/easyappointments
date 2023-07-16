<?php extend('layouts/message_layout') ?>

<?php section('content') ?>

<div class="inline-flex justify-center items-center py-5">
    <img id="success-icon" src="<?= base_url('assets/img/heroicons-mini/check-badge.svg') ?>" alt="success" />
</div>

<div class="mb-5 space-y-5">
    <h4 class="mb-5">
        <?= lang('appointment_paymentPaid_text') ?>
    </h4>

    <p>
        <?= lang('appointment_details_was_sent_to_you') ?>
    </p>

    <p class="mb-5 text-muted">
        <small>
            <?= lang('check_spam_folder') ?>
        </small>
    </p>

    <a href="<?= site_url() ?>" class="btn btn-primary btn-large rounded-full">
        <i class="fas fa-calendar-alt me-2"></i>
        <?= lang('go_to_booking_page') ?>
    </a>

    <a href="<?= vars('add_to_google_url') ?>" id="add-to-google-calendar" class="btn btn-primary rounded-full"
        target="_blank">
        <i class="fas fa-plus me-2"></i>
        <?= lang('add_to_google_calendar') ?>
    </a>
</div>

<?php section('content') ?>

<?php section('scripts') ?>

<?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]) ?>
<?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url')]) ?>

<?php section('scripts') ?>