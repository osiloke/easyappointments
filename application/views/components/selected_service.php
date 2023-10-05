<?php
?>
<div class="space-y-5 display-selected-service-tile invisible">
    <div class=" text-[#888888] text-left uppercase" style="font: 700 12px/18px 'Inter', sans-serif">
        Selected Service
    </div>
    <div class="overflow-hidden bg-[#ffffff] rounded-lg border-solid border-grey-50 border shrink-0 w-full p-10" style="
          box-shadow: var(
            --shadows-small-box-shadow,
            0px 2px 5px 0px rgba(103, 110, 118, 0.08),
            0px 1px 1px 0px rgba(0, 0, 0, 0.12)
          );
        ">
        <div class="flex flex-col gap-6 items-start justify-start shrink-0">
            <?php if (sizeof($available_services) > 1) { ?>
                <button data-step_index="<?= $step ?>"
                    class="button-back-service rounded-[100px] flex flex-col gap-2 items-start justify-center shrink-0 relative overflow-hidden">
                    <div class="flex flex-row gap-2 items-center justify-center self-stretch shrink-0 relative">
                        <svg class="shrink-0 relative overflow-visible" style="" width="18" height="18" viewBox="0 0 18 18"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.625 9L3.375 9M3.375 9L8.4375 14.0625M3.375 9L8.4375 3.9375" stroke="black"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <div class="text-primary-black text-center relative flex items-center justify-center" style="
                font: var(
                  --body-sm-semi-bold,
                  500 14px/20px 'DM Sans',
                  sans-serif
                );
              ">
                            Choose another service
                        </div>
                    </div>
                </button>
            <?php } ?>
            <div class="flex flex-col gap-[5px] items-start justify-start shrink-0 relative">
                <div class="text-grey-1000 text-left relative flex items-center justify-start display-selected-service"
                    style="
              font: var(--body-md-bold, 700 16px/24px 'DM Sans', sans-serif);
            ">
                </div>
                <div class="text-grey-600 text-right relative flex items-center justify-end" style="
              font: var(--body-sm-medium, 500 14px/20px 'DM Sans', sans-serif);
            ">
                    Duration: &nbsp; <span class="display-selected-service-duration" />
                </div>
                <div class="text-grey-500 text-left display-selected-service-description" style="
              font: var(--body-xs-medium, 500 12px/18px 'Inter', sans-serif);
            ">
                </div>
            </div> 
            <div class="flex flex-col gap-0 items-start justify-start self-stretch shrink-0 relative">
                <div class="text-[#888888] text-left uppercase relative "
                    style="font: 700 12px/18px 'Inter', sans-serif">
                    Service Price
                </div>
                <div class="text-grey-900 text-left relative flex items-center justify-start display-selected-service-price"
                    style="
              font: var(
                --headings-sm-extra-bold,
                700 30px/38px 'DM Sans',
                sans-serif
              );
            ">
                </div>
            </div> 
        </div>
    </div>
</div>
