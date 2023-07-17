<?php extend('layouts/message_layout') ?>

<?php section('content') ?>

<div class="inline-flex justify-center items-center py-5">
    <img id="success-icon" src="<?= base_url('assets/img/heroicons-mini/check-badge.svg') ?>" alt="success" />
</div>
<?php if (!vars('is_paid') && vars('payment_link') && vars('service')["price"] > 0): ?>

    <div class="mb-5 space-y-5 space-x-2">
        <h4 class="mb-5">
            <?= lang('appointment_payment_text') ?>
        </h4>
        <div class="space-x-2 space-y-2">

            <a href="<?= vars('payment_link') ?>" id="open-payment-process" class="btn btn-primary rounded-full inline mt-4"
                target="_blank">
                <i class="fas fa-credit-card me-2"></i>
                <?= lang('open_payment_process') ?>
            </a>
        </div>
    <?php else: ?>

        <div class="mb-5 space-y-5 space-x-2">
            <h4 class="mb-5">
                <?= lang('appointment_registered') ?>
            </h4>

            <p>
                <?= lang('appointment_details_was_sent_to_you') ?>
            </p>

            <p class="mb-5 text-muted">
                <small>
                    <?= lang('check_spam_folder') ?>
                </small>
            </p>
            <div class="space-x-2 space-y-2">

                <a href="<?= site_url() . '?provider=' . vars('appointment')["id_users_provider"] ?>"
                    class="btn btn-primary btn-large rounded-full  inline">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <?= lang('go_to_booking_page') ?>
                </a>

                <a href="<?= vars('add_to_google_url') ?>" id="add-to-google-calendar"
                    class="btn btn-primary rounded-full inline " target="_blank">
                    <i class="fas fa-plus me-2"></i>
                    <?= lang('add_to_google_calendar') ?>
                </a>
            </div>
        </div>
    <?php endif ?>

    <?php end_section('content') ?>

    <?php section('scripts') ?>

    <?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]) ?>
    <?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url')]) ?>

    <?php end_section('scripts') ?>
