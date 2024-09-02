<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>
<div id="surveyContainer"></div>
<?php end_section('content'); ?>

<?php section('styles'); ?>
<!-- Default V2 theme -->
<link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet"><!-- Apply the Bootstrap theme -->
<style>
  body {
    /* --primary: #1ab7fa; */
    --primary: #1F1F1F;
    /* --primary-light: rgba(26, 183, 250, 0.1); */
    --primary-light: #0000003D;
    --foreground: #ededed;
    --primary-foreground: #ffffff;
    /* --secondary: #1ab7fa; */
    --secondary: #141414;
    --success: #629369;
    /* --background: #555555;*/
    /* --background-dim: #4d4d4d;
    --background-dim-light: #4d4d4d; */
  }

  .sd-navigation__complete-btn,
  .sd-navigation__complete-btn:hover {
    background-color: var(--success);
  }

  /* .sv-list__item--selected {
    background-color: var(--primary-foreground)
  } */

  .sv-string-viewer {
    color: black
  }
</style>
<?php end_section('styles'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/packages_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/categories_http_client.js') ?>"></script>
<script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>

<script>
  $(function() {
    $.ajax({
      url: "<?= asset_url('assets/forms/service-creation.json') ?>",
      dataType: "json",
      success: function(data) {
        var package = vars("package");
        let initialData = package ?? {};
        if (!package) {
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
                  } else if (ffield.name == 'service_category') {
                    ffield.choices = vars("categories").map(({
                      name,
                      id
                    }) => ({
                      value: id,
                      text: name
                    }))
                  }
                })
                initialData[field.name].push(panels)
              }
            })
          });
        } else {
          data.pages.forEach(element => {
            element.elements.forEach(field => {
              if (field.type == 'paneldynamic') {
                let panels = {}
                field.templateElements.forEach(ffield => {
                  if (ffield.name == 'service_category') {
                    ffield.choices = vars("categories").map(({
                      name,
                      id
                    }) => ({
                      value: id,
                      text: name
                    }))
                  }
                })
              }
            })
          });
        }
        const survey = new Survey.Model({
          // completedHtml: `<div class="alert alert-success bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded relative" role="alert">
          //   <strong class="font-bold">Creating your package</strong>
          // </div>`,
          completedHtml: '',
          showCompletedPage: true,
          ...data,
        });
        survey.data = initialData;
        survey.onComplete.add((sender, options) => {
          options.showSaveInProgress();
          App.Http.Packages.save(sender.data).done((response) => {
            if (!response.success) {
              App.Layouts.Backend.displayNotification(lang('Failed, try again'));
              survey.clear(false, false);
            } else {
              options.showSaveSuccess();
              App.Layouts.Backend.displayNotification(lang('Success'));
              window.location.href = App.Utils.Url.siteUrl('packages');
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