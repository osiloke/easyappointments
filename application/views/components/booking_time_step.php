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
        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-10">
            <div class="w-full lg:w-4/12">
                <?php component('provider_card', ['hide_service' => FALSE, 'company_name' => vars('company_name'), 'company_logo' => vars('company_logo')]) ?>
            </div>
            <div class="w-full lg:w-9/12bg-white rounded-lg gap-10 px-5 shadow">
                <h2 class="frame-title">
                    <?= lang('appointment_date_and_time') ?>
                </h2>
                <div class="flex flex-col lg:flex-row">
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
    </div>

    <div class="flex flex-row justify-between my-2">
        <button type="button" id="button-back-2" class="btn button-back btn-outline-secondary" data-step_index="2">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <button type="button" id="button-next-2" class="button-next" data-step_index="2">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>