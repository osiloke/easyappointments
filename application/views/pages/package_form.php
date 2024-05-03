<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>
<div id="surveyContainer"></div>
<?php end_section('content'); ?>

<?php section('styles'); ?>
<!-- Default V2 theme -->
<link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet"><!-- Apply the Bootstrap theme -->

<?php end_section('styles'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/packages_http_client.js') ?>"></script>
<script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>

<script>
  $(function() {
    $.ajax({
      url: "<?= asset_url('assets/forms/service-creation.json') ?>",
      dataType: "json",
      success: function(data) {
        let initialData = {};
        data.pages.forEach(element => {
          element.elements.forEach(field => {
            if (field.type == 'paneldynamic') {
              initialData[field.name] = []
              let panels = {}
              field.templateElements.forEach(ffield => {
                if (ffield.type == 'multipletext') {
                  let time = '09:00'
                  switch (ffield.name) {
                    case 'working_plan_start_time':
                      break;
                    case 'working_plan_stop_time':
                      time = '18:00'
                      break;
                    case 'break_start_time':
                      time = null
                      break;
                    case 'break_time_stop_time':
                      time = null
                      break;

                    default:
                      break;
                  }

                  let items = {}
                  ffield.items.forEach(item => {
                    if (item.inputType == 'time' && time != null) {
                      items[item.name] = time
                    }
                  })
                  panels[ffield.name] = items;
                }
              })
              initialData[field.name].push(panels)
            }
          })
        });

        const survey = new Survey.Model({
          // completedHtml: `<div class="alert alert-success bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded relative" role="alert">
          //   <strong class="font-bold">Creating your package</strong>
          // </div>`,
          completedHtml: '',
          showCompletedPage: true,
          navigateToUrl: "/calendar",
          ...data,
        });
        survey.data = initialData;
        survey.onComplete.add((sender, options) => {
          options.showSaveInProgress();
          App.Http.Packages.save(sender.data).done((response) => {
            if (!response.success) {
              App.Layouts.Backend.displayNotification(lang('Package creation failed'));
              survey.clear(false, false);
            } else {
              options.showSaveSuccess();
              App.Layouts.Backend.displayNotification(lang('Package created'));
              window.location.href = App.Utils.Url.siteUrl('/calendar');
            }
          }).catch((e) => {
            // options.showSaveError();
            survey.clear(false, false);
          });
        });
        $("#surveyContainer").Survey({
          model: survey
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Handle AJAX request error
      }
    });
  });
</script>
<?php end_section('scripts'); ?>