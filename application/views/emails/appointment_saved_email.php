<?php
/**
 * Local variables.
 *
 * @var string $subject
 * @var string $message
 * @var array $appointment
 * @var array $service
 * @var array $provider
 * @var array $customer
 * @var array $settings
 * @var array $timezone
 * @var string $appointment_link
 * @var string $add_to_google_url
 */
?>

<html lang="en">
<style>
    @media (max-width: 600px) {
        .button-div {
            flex-direction: column;
        }
    }
</style>

<head>
    <title>
        <?= lang('appointment_details_title') ?> |
        <?= e($settings['company_name']) ?>
    </title>
</head>

<body style="font: 13px arial, helvetica, tahoma;">

    <div class="email-container" style="max-width: 650px; border: 1px solid #eee; margin: 30px auto;">
        <div id="header" style="background-color: black; height: 112px; padding: 10px 15px; text-align: center;">
            <strong id="logo" style="color: white; font-size: 20px; margin-top: 55px; display: inline-block">
                <img src="<?= base_url('assets/img/logo-white.svg') ?>" alt="logo">
            </strong>
        </div>

        <div id="content" style="padding: 40px 45px; min-height: 100px;">

            <h2
                style="text-align: center; color: black; font-size: 18px; font-weight: 700; line-height: 20px; word-wrap: break-word; margin-top: 20px;">
                Your appointment has been successfully booked!
            </h2>
            <p
                style="max-width: 572px; text-align: center; color: black; font-size: 13px; font-weight: 400; line-height: 20px; word-wrap: break-word">
                <?= $message ?>
            </p>

            <p style="text-align: center">
                <!-- <?= $message ?> -->
            </p>
            <div
                style="width: 90%; height: 0px; border: 0.50px #EAEAEB solid; margin-top: 30px; margin-bottom: 30px; margin-left: auto; margin-right: auto;">
            </div>

            <h2>
                <?= lang('customer_details_title') ?>
            </h2>

            <table id="customer-details">
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('name') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($customer['first_name'] . ' ' . $customer['last_name']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('email') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($customer['email']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('phone_number') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($customer['phone_number']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('address') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($customer['address']) ?>
                    </td>
                </tr>
            </table>
            <h2>
                <?= lang('appointment_details_title') ?>
            </h2>

            <table id="appointment-details">
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('service') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($service['name']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('provider') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($provider['first_name'] . ' ' . $provider['last_name']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('start') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= format_date_time($appointment['start_datetime']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('end') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= format_date_time($appointment['end_datetime']) ?>

                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('timezone') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= format_timezone($timezone) ?>
                    </td>
                </tr>

                <tr>
                    <td class="label" style="padding: 3px;font-weight: bold;">
                        <?= lang('description') ?>
                    </td>
                    <td style="padding: 3px;">
                        <?= e($service['description']) ?>
                    </td>
                </tr>

                <?php if (!empty($appointment['location'])): ?>
                    <tr>
                        <td class="label" style="padding: 3px;font-weight: bold;">
                            <?= lang('location') ?>
                        </td>
                        <td style="padding: 3px;">
                            <?= e($appointment['location']) ?>
                        </td>
                    </tr>
                <?php endif ?>

                <?php if (!empty($appointment['notes'])): ?>
                    <tr>
                        <td class="label" style="padding: 3px;font-weight: bold;">
                            <?= lang('notes') ?>
                        </td>
                        <td style="padding: 3px;">
                            <?= e($appointment['notes']) ?>
                        </td>
                    </tr>
                <?php endif ?>
            </table>
            <div class="button-div"
                style="display: flex; width: 100%; min-height: 40px; justify-content: center; align-items: flex-start; gap: 10px;  margin-left: auto; margin-right: auto; margin-top: 50px; margin-bottom: 20px">
                <a href="<?= e($add_to_google_url) ?>"
                    style="width:100%; font-family: inherit; padding-left: 18px; padding-right: 18px; padding-top: 10px; padding-bottom: 10px; border-radius: 100px; overflow: hidden; border: 0.50px black solid; flex-direction: column; justify-content: center; gap: 8px; display: inline-flex; text-decoration: none;">
                    <div style=" justify-content: center; align-items: center; gap: 8px; display: inline-flex">
                        <div
                            style="text-align: center; color: black; font-size: 14px; font-family: DM Sans; font-weight: 500; line-height: 20px; word-wrap: break-word">
                            Add To Calendar</div>
                        <div style="width: 18px; height: 18px; position: relative">
                            <img src="<?= base_url('assets/img/google-calendar.png') ?>" alt="calendar-icon">
                        </div>
                    </div>
                </a>
                <a href="<?= site_url('/booking_confirmation/of/' . e($appointment['hash'])) ?>"
                    style="width:100%; padding-left: 18px; padding-right: 18px; padding-top: 10px; padding-bottom: 10px; border-radius: 100px; overflow: hidden; border: 0.50px black solid; flex-direction: column; justify-content: center; gap: 8px; display: inline-flex; text-decoration: none;">
                    <div style="justify-content: center; align-items: center; gap: 8px; display: inline-flex">
                        <div
                            style="text-align: center; color: black; font-size: 14px; font-family: DM Sans; font-weight: 500; line-height: 20px; word-wrap: break-word">
                            View Confirmation</div>
                        <!-- <div style="width: 18px; height: 18px; position: relative">
                        </div> -->
                    </div>
                </a>
                <a href="<?= e($appointment['location']) ?>" target="_blank"
                    style="width:100%; padding-left: 18px; padding-right: 18px; padding-top: 10px; padding-bottom: 10px; background: black; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.12); border-radius: 100px; overflow: hidden; flex-direction: column; justify-content: center; gap: 8px; display: inline-flex; text-decoration: none;">
                    <div style="justify-content: center; align-items: center; gap: 8px; display: inline-flex">
                        <div
                            style="text-align: center; color: white; font-size: 14px; font-family: DM Sans; font-weight: 500; line-height: 20px; word-wrap: break-word">
                            Join Meeting</div>
                        <div style="width: 18px; height: 18px; position: relative">
                            <img src="<?= base_url('assets/img/heroicons-outline/video-camera.png') ?>" alt="join-icon">
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div id="footer" style="padding: 10px; text-align: center; margin-top: 10px;
                border-top: 1px solid #EEE; background: #F0F0F0;">
            <a href="<?= e($settings['company_link']) ?>"
                style="text-decoration: none; text-align: center; color: #9F9F9F; font-size: 16px; font-weight: 500; line-height: 24px; letter-spacing: 0.20px; word-wrap: break-word; text-decoration: none;">
                <?= e($settings['company_name']) ?> | <?php echo date("Y"); ?>
            </a>
        </div>
    </div>

</body>

</html>