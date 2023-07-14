<?php
/**
 * Local variables.
 *
 * @var bool $hide_service 
 */
?>
<div class="bg-white rounded-lg shadow border border-neutral-50 flex flex-row h-36 w-full items-center px-4 gap-4">
    <div class="avatar online">
        <div class="w-16 rounded-full shadow">
            <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=Molly" />
        </div>
    </div>
    <div class="flex flex-col w-full">
        <span class="display-selected-provider text-neutral-600 text-xl font-bold leading-loose">
        </span>
        <? if ($hide_service != TRUE) { ?>
            <span class="display-selected-service text-neutral-600 text-base font-medium leading-normal">
            <? } ?>
        </span>

    </div>
</div>