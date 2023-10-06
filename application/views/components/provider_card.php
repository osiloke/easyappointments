<?php
/**
 * Local variables.
 *
 * @var bool $hide_service
 * @var $secretary
 */
?>
<div class="bg-white rounded-lg shadow border border-neutral-50 flex flex-row py-4 w-full items-start px-4 gap-4">
    <div>
        <div class="w-24 h-32 transition ease-in-out delay-150">
            <!-- <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=Molly" /> -->
            <img class="w-24 my-2" src="<?= base_url('assets/img/Avatars.png') ?>" />
        </div>
    </div>
    <div class="flex flex-col w-8/12">
        <span class="text-neutral-600 text-xl font-bold leading-loose mt-2">
            <?= $secretary["first_name"] ?> <?= $secretary["last_name"] ?>
        </span>
        <div class="text-neutral-600 text-base font-medium leading-normal"><?= $secretary["notes"] ?></div>
        <?php if ($hide_service != TRUE): ?>
        <span class="display-selected-provider text-neutral-600 text-xl font-bold leading-loose"> 
        </span>
           <!--  <span class="display-selected-service text-neutral-600 text-base font-medium leading-normal">
        </span> -->
        <?php endif ?>
    </div>
</div>
