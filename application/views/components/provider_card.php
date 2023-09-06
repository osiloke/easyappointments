<?php
/**
 * Local variables.
 *
 * @var bool $hide_service 
 */
?>
<div class="bg-white rounded-lg shadow border border-neutral-50 flex flex-row h-36 w-full items-center px-4 gap-4">
    <div>
        <div class="w-16 h-16 transition ease-in-out delay-150">
            <!-- <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=Molly" /> -->
            <img class="w-12 my-2" src="<?= base_url('assets/img/Avatars.png') ?>" />
        </div>
    </div>
    <div class=" flex flex-col w-full">
        <span class="display-selected-provider text-neutral-600 text-xl font-bold leading-loose">
        </span>
        <? if ($hide_service != TRUE) { ?>
            <span class="display-selected-service text-neutral-600 text-base font-medium leading-normal">
            <? } ?>
        </span>
    </div>
</div>