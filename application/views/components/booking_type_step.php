<?php
/**
 * Local variables.
 *
 * @var array $available_services
 * @var array $available_providers
 */

$has_category = false;
foreach ($available_services as $service) {
    if (!empty($service['category_id'])) {
        $has_category = true;

        break;
    }
}
// Group services by category
$grouped_services = [];

foreach ($available_services as $service) {
    if (!empty($service['category_id'])) {
        if (!isset($grouped_services[$service['category_name']])) {
            $grouped_services[$service['category_name']] = [];
        }

        $grouped_services[$service['category_name']][] = $service;
    }
}

// Add uncategorized services
$grouped_services['uncategorized'] = [];

foreach ($available_services as $service) {
    if ($service['category_id'] == null) {
        $grouped_services['uncategorized'][] = $service;
    }
}
?>
<div id="wizard-frame-1" class="wizard-frame" style="visibility: hidden;">
    <div class="frame-container">

        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-10">
            <div class="w-full lg:w-5/12">
                <?php component('provider_card', [
                    'hide_service' => count($available_providers) == 1,
                    'secretary' => vars('secretary'),
                ]); ?>
            </div>
            <div id="step-content">
                <h2 class="frame-title normal-case">
                    <?= lang('Choose a service to book') ?>
                </h2>

                <div class="row frame-content">
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="select-service">
                                <strong>
                                    <?= lang('service') ?>
                                </strong>
                            </label>    -->

                        <div id="provider-list" class="mb-3 <?php if (
                            count($available_providers) == 1
                        ): ?>hidden<?php endif; ?>">
                                <label for="select-provider hidden">
                                    <strong class="hidden">
                                        <?= lang('provider') ?>
                                    </strong>
                                </label>
                                <select id="select-provider" class="form-control hidden"> 
                                    <?php if (
                                        count($available_providers) > 1
                                    ): ?><option value></option><?php endif; ?>          
                                    <?php foreach ($available_providers as $provider): ?>         
                                    <option value="<?= $provider['id'] ?>">
                                        <?= $provider['first_name'] . ' ' . $provider['last_name'] ?>
                                    </option>                          
                                    <?php endforeach; ?>  
                                    
                                </select>  
                                <div role="radiogroup" id="select-provider-tile">
                                    <div class="service-grid">
                                        <?php foreach (
                                            $available_providers
                                            as $provider
                                        ): ?>                                        
                                        <?php component('provider_tile', [
                                            'id' => $provider['id'],
                                            'image' => $provider['image'],
                                            'first_name' => $provider['first_name'],
                                            'last_name' => $provider['last_name'],
                                            'description' => $provider['notes'] ?? '',
                                        ]); ?>
                                        <?php endforeach; ?>  
                                    </div>
                                </div>
                            </div>
                            <div id="service-list" class="<?php if (
                                count($available_providers) > 1
                            ): ?>hidden<?php endif; ?>">
                                <div class="pb-10 <?php if (count($available_providers) == 1): ?>hidden<?php endif; ?>">
                                    <button data-step_index="1"
                                            class="button-back-provider rounded-[100px] flex flex-col gap-2 items-start justify-center shrink-0 relative overflow-hidden">
                                            <div class="flex flex-row gap-2 items-center justify-center self-stretch shrink-0 relative">
                                                <svg class="shrink-0 relative overflow-visible" style="" width="18" height="18" viewBox="0 0 18 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.625 9L3.375 9M3.375 9L8.4375 14.0625M3.375 9L8.4375 3.9375" stroke="black"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>

                                                <div class="text-primary-black text-center relative flex items-center justify-center display-selected-provider" style="
                                        font: var(
                                        --body-sm-semi-bold,
                                        500 14px/20px 'DM Sans',
                                        sans-serif
                                        );
                                    ">
                                                    
                                                </div>
                                            </div>
                                        </button>
                                </div>

                            <select id="select-service" class="form-control w-full lg:w-6/12 hidden"> 
                                <option value></option>
                            <?php foreach ($available_services as $service): ?>
                                <option value="<?= $service['id'] ?>"><?= e($service['name']) ?></option>
                            <?php endforeach; ?>
                            </select>
                                <div class="service-grid" id="service-tiles">
                                    <?php foreach ($grouped_services as $key => $group): ?>

                                        <?php if (count($group) > 0): ?>
                                            
                                            <?php foreach ($group as $service): ?>
                                            
                                            <?php component('service_tile', [
                                                'id' => $service['id'],
                                                'name' => $service['name'],
                                                'description' => $service['description'],
                                                'price' => $service['price'],
                                                'fee' => $service['fee'] ?? 0,
                                                'duration' => $service['duration'],
                                            ]); ?>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    <?php endforeach; ?>  
                                </div>
                            </div>
                        <?php if ($is_paid): ?>
                            <p class="warn">
                            <?= strtr(lang('service_paid_warning'), [
                                '{$mail_link}' => strtr('<a href="maiilto:{$company_email}">{$company_email}</a>', [
                                    '{$company_email}' => $company_email,
                                ]),
                            ]) ?>
                            <?= lang('') ?>
                            </p>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
    </div>

    <div class="command-buttons">
        <span>&nbsp;</span>

        <button type="button" id="button-next-1" class="btn btn-primary button-next" data-step_index="1">
            <?= lang('Proceed') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>
