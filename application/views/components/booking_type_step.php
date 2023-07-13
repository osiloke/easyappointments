<?php
/**
 * Local variables.
 *
 * @var array $available_services
 */
?>

<div id="wizard-frame-1" class="wizard-frame" style="visibility: hidden;">
    <div class="frame-container">

        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-10">
            <?php component('provider_card', ["hide_service" => true]) ?>
            <div class="w-full bg-white rounded-lg lg:w-6/12 py-4">
                <h2 class="frame-title">
                    <?= lang('choose service') ?>
                </h2>

                <div class="row frame-content">
                    <div class="col">
                        <div class="mb-3">
                            <label for="select-service">
                                <strong>
                                    <?= lang('service') ?>
                                </strong>
                            </label>

                            <?php if ($is_paid): ?>
                                <select id="select-service" class="form-control w-7/12" disabled="true">
                                <?php else: ?>
                                    <select id="select-service" class="form-control w-full lg:w-8/12">
                                    <?php endif ?>
                                    <?php
                                    // Group services by category, only if there is at least one service with a parent category.
                                    $has_category = FALSE;
                                    foreach ($available_services as $service) {
                                        if (!empty($service['category_id'])) {
                                            $has_category = TRUE;
                                            break;
                                        }
                                    }

                                    if ($has_category) {
                                        $grouped_services = [];

                                        foreach ($available_services as $service) {
                                            if (!empty($service['category_id'])) {
                                                if (!isset($grouped_services[$service['category_name']])) {
                                                    $grouped_services[$service['category_name']] = [];
                                                }

                                                $grouped_services[$service['category_name']][] = $service;
                                            }
                                        }

                                        // We need the uncategorized services at the end of the list, so we will use another
                                        // iteration only for the uncategorized services.
                                        $grouped_services['uncategorized'] = [];
                                        foreach ($available_services as $service) {
                                            if ($service['category_id'] == NULL) {
                                                $grouped_services['uncategorized'][] = $service;
                                            }
                                        }

                                        foreach ($grouped_services as $key => $group) {
                                            $group_label = $key !== 'uncategorized'
                                                ? $group[0]['category_name']
                                                : 'Uncategorized';

                                            if (count($group) > 0) {
                                                echo '<optgroup label="' . e($group_label) . '">';
                                                foreach ($group as $service) {
                                                    echo '<option value="' . $service['id'] . '">'
                                                        . e($service['name']) . '</option>';
                                                }
                                                echo '</optgroup>';
                                            }
                                        }
                                    } else {
                                        foreach ($available_services as $service) {
                                            echo '<option value="' . $service['id'] . '">' . e($service['name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>

                                <div class="service-grid">
                                    <?php
                                    foreach ($grouped_services as $key => $group) {
                                        $group_label = $key !== 'uncategorized'
                                            ? $group[0]['category_name']
                                            : 'Uncategorized';
                                        if (count($group) > 0) {
                                            foreach ($group as $service) { ?>
                                                <?php component('service_tile', ["name" => $service['name'], "description" => '', "price" => $service['price']]) ?>
                                            <?php }
                                            ;
                                        }
                                        ?>

                                    <?php } ?>
                                </div>
                                <?php if ($is_paid): ?>
                                    <p class="warn">
                                        <?= strtr(
                                            lang('service_paid_warning'),
                                            [
                                                '{$mail_link}' => strtr('<a href="maiilto:{$company_email}">{$company_email}</a>', [
                                                    '{$company_email}' => $company_email
                                                ])
                                            ]
                                        )
                                            ?>
                                        <?= lang('') ?>
                                    </p>
                                <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="select-provider">
                                <strong>
                                    <!-- <?= lang('provider') ?> -->
                                </strong>
                            </label>

                            <select disabled id="select-provider" class="form-control hidden"></select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="command-buttons">
        <span>&nbsp;</span>

        <button type="button" id="button-next-1" class="btn btn-primary rounded-full button-next" data-step_index="1">
            <?= lang('Proceed') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>