<?php
/**
 * Local variables.
 *
 * @var string $company_name
 */
?>

<div class="flex flex-col lg:flex-row justify-between item-center px-2.5 py-2 md:mx-4 mx-2 gap-2">
    <div id="booking-name">
        <span class="text-2xl md:text-3xl leading-10 font-bold">
            <?= lang('Booking Appointment') ?>
        </span>
    </div>
    <!-- <div id="steps" class="m-0">
        <div id="step-1" class="book-step active-step" data-tippy-content="<?= lang('service_and_provider') ?>">
            <strong class="text-primary">1</strong>
        </div>

        <div id="step-2" class="book-step" data-bs-toggle="tooltip"
            data-tippy-content="<?= lang('appointment_date_and_time') ?>">
            <strong class="text-primary">2</strong>
        </div>
        <div id="step-3" class="book-step" data-bs-toggle="tooltip"
            data-tippy-content="<?= lang('customer_information') ?>">
            <strong class="text-primary">3</strong>
        </div>
        <div id="step-4" class="book-step" data-bs-toggle="tooltip"
            data-tippy-content="<?= lang('appointment_confirmation') ?>">
            <strong class="text-primary">4</strong>
        </div>
    </div> -->
    <div class="join">
        <div id="step-1"
            class="join-item bg-white border border-gray-200 flex-col justify-center items-center gap-2 inline-flex">
            <div class="px-2.5 py-2 justify-center items-center gap-2 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M5.5 4.5H13.5M5.5 8H13.5M5.5 11.5H13.5M2.5 4.5H2.505V4.505H2.5V4.5ZM2.75 4.5C2.75 4.63807 2.63807 4.75 2.5 4.75C2.36193 4.75 2.25 4.63807 2.25 4.5C2.25 4.36193 2.36193 4.25 2.5 4.25C2.63807 4.25 2.75 4.36193 2.75 4.5ZM2.5 8H2.505V8.005H2.5V8ZM2.75 8C2.75 8.13807 2.63807 8.25 2.5 8.25C2.36193 8.25 2.25 8.13807 2.25 8C2.25 7.86193 2.36193 7.75 2.5 7.75C2.63807 7.75 2.75 7.86193 2.75 8ZM2.5 11.5H2.505V11.505H2.5V11.5ZM2.75 11.5C2.75 11.6381 2.63807 11.75 2.5 11.75C2.36193 11.75 2.25 11.6381 2.25 11.5C2.25 11.3619 2.36193 11.25 2.5 11.25C2.63807 11.25 2.75 11.3619 2.75 11.5Z"
                        stroke="#454C52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-center text-neutral-600 text-sm font-semibold leading-tight">
                    <?= lang('service') ?>
                </div>
            </div>
        </div>
        <div id="step-2"
            class="join-item bg-white border border-gray-200 flex-col justify-center items-center gap-2 inline-flex">
            <div class="px-2.5 py-2 justify-center items-center gap-2 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M4.5 2V3.5M11.5 2V3.5M2 12.5V5C2 4.17157 2.67157 3.5 3.5 3.5H12.5C13.3284 3.5 14 4.17157 14 5V12.5M2 12.5C2 13.3284 2.67157 14 3.5 14H12.5C13.3284 14 14 13.3284 14 12.5M2 12.5V7.5C2 6.67157 2.67157 6 3.5 6H12.5C13.3284 6 14 6.67157 14 7.5V12.5M8 8.5H8.005V8.505H8V8.5ZM8 10H8.005V10.005H8V10ZM8 11.5H8.005V11.505H8V11.5ZM6.5 10H6.505V10.005H6.5V10ZM6.5 11.5H6.505V11.505H6.5V11.5ZM5 10H5.005V10.005H5V10ZM5 11.5H5.005V11.505H5V11.5ZM9.5 8.5H9.505V8.505H9.5V8.5ZM9.5 10H9.505V10.005H9.5V10ZM9.5 11.5H9.505V11.505H9.5V11.5ZM11 8.5H11.005V8.505H11V8.5ZM11 10H11.005V10.005H11V10Z"
                        stroke="#454C52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-center text-neutral-600 text-sm font-semibold leading-tight">
                    <?= lang('Date & Time') ?>
                </div>
            </div>
        </div>
        <div id="step-3"
            class="join-item   bg-white border-r border-t border-b border-gray-200 flex-col justify-center items-center gap-2 inline-flex">
            <div class="px-2.5 py-2 justify-center items-center gap-2 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M11.9877 12.4832C11.0747 11.2783 9.62826 10.5 8 10.5C6.37174 10.5 4.92526 11.2783 4.01231 12.4832M11.9877 12.4832C13.2223 11.3842 14 9.78293 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 9.78293 2.77767 11.3842 4.01231 12.4832M11.9877 12.4832C10.9277 13.4267 9.53078 14 8 14C6.46922 14 5.07234 13.4267 4.01231 12.4832M10 6.5C10 7.60457 9.10457 8.5 8 8.5C6.89543 8.5 6 7.60457 6 6.5C6 5.39543 6.89543 4.5 8 4.5C9.10457 4.5 10 5.39543 10 6.5Z"
                        stroke="#454C52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-center text-neutral-600 text-sm font-semibold leading-tight">
                    <?= lang('Booking Information') ?>
                </div>
            </div>
        </div>
        <div id="step-4"
            class="join-item   bg-white rounded-tr--full rounded-br--full border-r border-t border-b border-gray-200 flex-col justify-center items-center gap-2 inline-flex">
            <div class="px-2.5 py-2 justify-center items-center gap-2 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M1.5 12.5C5.1448 12.5 8.67573 12.9875 12.0312 13.9008C12.5158 14.0327 13 13.6724 13 13.1701V12.5M2.5 3V3.5C2.5 3.77614 2.27614 4 2 4H1.5M1.5 4V3.75C1.5 3.33579 1.83579 3 2.25 3H13.5M1.5 4V10M13.5 3V3.5C13.5 3.77614 13.7239 4 14 4H14.5M13.5 3H13.75C14.1642 3 14.5 3.33579 14.5 3.75V10.25C14.5 10.6642 14.1642 11 13.75 11H13.5M14.5 10H14C13.7239 10 13.5 10.2239 13.5 10.5V11M13.5 11H2.5M2.5 11H2.25C1.83579 11 1.5 10.6642 1.5 10.25V10M2.5 11V10.5C2.5 10.2239 2.27614 10 2 10H1.5M10 7C10 8.10457 9.10457 9 8 9C6.89543 9 6 8.10457 6 7C6 5.89543 6.89543 5 8 5C9.10457 5 10 5.89543 10 7ZM12 7H12.005V7.005H12V7ZM4 7H4.005V7.005H4V7Z"
                        stroke="#454C52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-center text-neutral-600 text-sm font-semibold leading-tight">
                    <?= lang('Payment & Confirmation') ?>
                </div>
            </div>
        </div>
    </div>
</div>