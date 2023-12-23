<?php extend('layouts/message_layout'); ?>

<?php section('content'); ?>
<?php $fmt = numfmt_create('en_NG', NumberFormatter::CURRENCY); ?>
<?php if (!vars('is_paid') && vars('payment_link') && vars('service')['price'] > 0): ?>
    <div class="mb-5 space-y-5 space-x-2">
        <div style=" flex-direction: column; justify-content: flex-start; align-items: center;
        gap: 5px; display: inline-flex">
            <div>
                <img id="success-icon" src="<?= base_url(
                    'assets/img/heroicons-solid/credit-card.svg',
                ) ?>" alt="success" />
            </div>
            <div
                style="color: #1A1D1F; font-size: 36px; font-family: Inter; font-weight: 900; line-height: 44px; word-wrap: break-word">
                Complete your booking</div>
            <div
                style="color: #1A1D1F; font-size: 18px; font-family: Inter; font-weight: 600; line-height: 28px; word-wrap: break-word">
                Just one more step</div>
            <div
                style="text-align: center; color: #1A1D1F; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 24px; word-wrap: break-word">
                Click "Proceed with payment" to complete your booking </div>
        </div>
        <div class="bg-white rounded-lg shadow border border-neutral-50 mx-2 my-5 lg:m-5 p-5 space-x-2 space-y-10">
            <div class="flex flex-col lg:flex-row text-left justify-between w-full gap-16">
                <div class="justify-start w:5/12">
                    <div class="text-zinc-900 text-lg font-medium leading-7">Service/Appointment Details
                    </div>
                    <div class="flex-col gap-5 inline-flex">
                        <div class="flex-col gap-2 flex">
                            <div class="text-gray-600 text-sm font-semibold leading-tight">Service</div>
                            <div class="text-zinc-900 text-base font-bold leading-normal">
                                <?= vars('service')['name'] ?>
                            </div>
                            <div class="text-zinc-900 text-base font-normal leading-normal">
                                <?= vars('service')['description'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-start items-start gap-8 grid grid-cols-2 w-full">
                    <div class="flex-col justify-start items-start gap-2 inline-flex">
                        <div class="text-gray-600 text-sm font-semibold leading-tight">Price</div>
                        <div class="text-zinc-900 text-base font-medium leading-normal">
                            <?= numfmt_format_currency($fmt, vars('service')['price'], 'NGN') ?>
                        </div>
                    </div>
                    <div class="flex-col justify-start items-start gap-2 inline-flex">
                        <div class="text-gray-600 text-sm font-semibold leading-tight">Fee</div>
                        <div class="text-zinc-900 text-base font-medium leading-normal">
                            <?= numfmt_format_currency($fmt, vars('service')['fee'], 'NGN') ?>
                        </div>
                    </div>
                    <div class="flex-col justify-start items-start gap-2 inline-flex">
                        <div class="text-gray-600 text-sm font-semibold leading-tight">Duration</div>
                        <div class="text-zinc-900 text-base font-medium leading-normal">
                            <?= vars('service')['duration'] ?> min(s)
                        </div>
                    </div>
                    <div class="flex-col justify-start items-start gap-2 inline-flex">
                        <div class="text-gray-600 text-sm font-semibold leading-tight">Start</div>
                        <div class="text-zinc-900 text-base font-medium leading-normal">
                            <?= format_date_time(vars('appointment')['start_datetime']) ?>
                            <?= vars('timezone') ?>
                        </div>
                    </div>
                    <div class="flex-col justify-start items-start gap-2 inline-flex">
                        <div class="text-gray-600 text-sm font-semibold leading-tight">End</div>
                        <?= format_date_time(vars('appointment')['end_datetime']) ?>
                        <?= vars('timezone') ?>
                    </div>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row justify-center space-x-2">
                <a href="<?= site_url() . '?provider=' . vars('appointment')['id_users_provider'] ?>"
                    class="btn rounded-full mt-4 btn-outline text-red-500">
                    <i id="payment-icon" class="fas fa-close me-2">
                    </i>
                    <?= lang('Cancel Booking') ?>
                </a>
                <a href="<?= vars(
                    'payment_link',
                ) ?>" id="open-payment-process" class="btn btn-primary rounded-full mt-4"
                    target="_blank">
                    <i id="payment-icon" class="fas fa-credit-card me-2">
                    </i>
                    <?= lang('open_payment_process') ?>
                </a>
            </div>
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

                <a href="<?= site_url() . '?provider=' . vars('appointment')['id_users_provider'] ?>"
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
    <?php endif; ?>

    <?php end_section('content'); ?>

    <?php section('scripts'); ?>

    <?php component('google_analytics_script', [
        'google_analytics_code' => vars('google_analytics_code'),
    ]); ?>
    <?php component('matomo_analytics_script', ['matomo_analytics_url' => vars('matomo_analytics_url')]); ?>

    <?php end_section('scripts'); ?>
