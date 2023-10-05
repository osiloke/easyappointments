<?php
/**
 * Local variables.
 *
 * @var array $grouped_timezones
 * @var array $available_services
 */

$fullday = 540; // 9 hours
$halfDay = 240;

$intervals = getTimeIntervals($fullday, $halfDay);

function getTimeIntervals($duration, $halfDay)
{
    $intervals = [];

    for ($i = 60; $i <= $duration; $i += 60) {
        $intervals[] = $i;

        if ($i >= 60 && !in_array(60, $intervals)) {
            $intervals[] = 60;
        }

        if ($i >= $halfDay && !in_array($halfDay, $intervals)) {
            $intervals[] = $halfDay;
        }
    }

    return $intervals;
}

?>

<div id="wizard-frame-2" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-10">
            <div class="w-full lg:w-5/12 flex flex-col gap-10">
                <?php component('provider_card', ["hide_service" => (count($available_providers) == 1), "secretary" => vars('secretary')]) ?>
                <?php component('selected_service', ['services' => $available_services, 'step' => '2']) ?>
            </div>
            <div id="step-content">
                <h2 class=" frame-title">
                    <?= lang('appointment_date_and_time') ?>
                </h2>
                <div class="justify-start items-center gap-10 inline-flex">
                    <div class="flex-col justify-center items-start inline-flex w-full">
                        <div class="text-black text-lg font-medium leading-7">How long will you like this session to last for?</div>
                        <div class="text-sm font-normal leading-tight">Note: This will affect the cost of your booking</div>
                    </div>
                    <div class="w-4/12 lg:w-4/12">
                        <select name="interval" class="select select-bordered w-full">

                        <?php foreach ($intervals as $interval): ?>

                        <option value="<?php echo $interval; ?>">
                        <?php $dur = $interval / 60; ?>
                            <?php if ($interval == $halfDay): ?>Half day<?php elseif ($interval == $fullday):?>Full day<?php else: ?> <?= $dur ?> Hour(s) <?php endif; ?>
                        </option>

                        <?php endforeach; ?>

                        </select>
                    </div>
                </div>
                <div class="h-10"></div>
                <div class="flex flex-col lg:flex-row gap-5 lg:gap-10">
                    <div class="w-full lg:w-6/12">
                        <div id="select-date" class="p-0 py-0"></div>
                    </div>
                    <div class="w-full lg:w-6/12">
                        <div id="select-time w-full">
                            <div class="w-full">
                                <label for="select-timezone" class="form-label">
                                    <?= lang('timezone') ?>
                                </label>
                                <?php component('timezone_dropdown', [
                                    'attributes'        => 'id="select-timezone" class="form-control" value="Africa/Lagos"',
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

    <div class="command-buttons">
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
