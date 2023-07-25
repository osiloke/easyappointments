<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Booking confirmation controller.
 *
 * Handles the booking confirmation related operations.
 *
 * @package Controllers
 */
class Booking_confirmation extends EA_Controller
{
    /**
     * Booking_confirmation constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('appointments_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('customers_model');

        $this->load->library('google_sync');
    }

    /**
     * Display the appointment registration success page.
     * 
     * @throws Exception
     */
    public function of()
    {
        $appointment_hash = $this->uri->segment(3);

        $occurrences = $this->appointments_model->get(['hash' => $appointment_hash]);

        if (empty($occurrences)) {
            redirect('appointments'); // The appointment does not exist.

            return;
        }

        $appointment = $occurrences[0];

        $add_to_google_url = $this->google_sync->get_add_to_google_url($appointment['id']);

        $service = $this->services_model->find($appointment['id_services']);

        $provider = $this->providers_model->find($appointment['id_users_provider']);

        $customer = $this->customers_model->find($appointment['id_users_customer']);

        $timezone = $customer['timezone'];
        $appointment_timezone = new DateTimeZone($provider['timezone']);

        $appointment_start = new DateTime($appointment['start_datetime'], $appointment_timezone);

        $appointment_end = new DateTime($appointment['end_datetime'], $appointment_timezone);

        if ($timezone && $timezone !== $provider['timezone']) {
            $custom_timezone = new DateTimeZone($timezone);

            $appointment_start->setTimezone($custom_timezone);
            $appointment['start_datetime'] = $appointment_start->format('Y-m-d H:i:s');

            $appointment_end->setTimezone($custom_timezone);
            $appointment['end_datetime'] = $appointment_end->format('Y-m-d H:i:s');
        }

        $payment_link = site_url('payment/link' . '/' . $appointment_hash);

        html_vars([
            'page_title'            => lang('success'),
            'company_color'         => setting('company_color'),
            'google_analytics_code' => setting('google_analytics_code'),
            'matomo_analytics_url'  => setting('matomo_analytics_url'),
            'add_to_google_url'     => $add_to_google_url,
            'is_paid'               => $appointment['is_paid'],
            'payment_link'          => $payment_link,
            'service'               => $service,
            'appointment'           => $appointment,
            'timezone'              => $timezone,
            'is_redirect'           => isset($_GET['r'])
        ]);

        $this->load->view('pages/booking_confirmation');
    }
}