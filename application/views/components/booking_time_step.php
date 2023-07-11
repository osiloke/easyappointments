<?php
/**
 * Local variables.
 *
 * @var array $grouped_timezones
 * @var array $available_services
 */
?>

<div id="wizard-frame-2" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <!-- <h2 class="frame-title"><?= lang('appointment_date_and_time') ?></h2> -->
        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-10">
            <div
                class="bg-white rounded-lg shadow border border-neutral-50 flex flex-row h-36 w-full lg:w-4/12 items-center px-4 gap-4">
                <div class="w-4 h-4 p-10 bg-white rounded-lg shadow border border-neutral-50"></div>
                <div class="flex flex-col w-full">
                    <span class="display-selected-provider text-neutral-600 text-xl font-bold leading-loose">
                    </span>
                    <span class="display-selected-service   text-neutral-600 text-base font-medium leading-normal">
                    </span>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row w-full lg:w-9/12 bg-white rounded-lg gap-10 px-5 shadow">
                <div class="w-full lg:w-6/12">
                    <div id="select-date" class="p-0 py-0 w-full"></div>
                </div>
                <div class="w-full lg:w-6/12 py-4">
                    <div id="select-time w-full">
                        <div class="w-full">
                            <label for="select-timezone" class="form-label">
                                <?= lang('timezone') ?>
                            </label>
                            <?php component('timezone_dropdown', [
                                'attributes' => 'id="select-timezone" class="form-control" value="UTC"',
                                'grouped_timezones' => $grouped_timezones
                            ]) ?>
                        </div>

                        <div id="available-hours"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-between my-2">
        <button type="button" id="button-back-2" class="btn button-back btn-outline-secondary" data-step_index="2">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-2" class="btn btn-rounded button-next btn-dark btn-primary"
            data-step_index="2">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>