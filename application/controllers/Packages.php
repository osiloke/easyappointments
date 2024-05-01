<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Packages controller.
 *
 * Handles the Package related operations.
 *
 * @package Controllers
 */
class Packages extends EA_Controller
{
    /**
     * Package constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('service_categories_model');
        $this->load->model('secretaries_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('packages_model');
        $this->load->model('roles_model');
        $this->load->model('users_model');

        $this->load->library('accounts');
        $this->load->library('timezones');
        $this->load->library('webhooks_client');
        $this->load->helper('text_helper');
    }

    /**
     * Render the backend space page.
     *
     * On this page secretary users will be able to manage spaces, which are eventually selected by customers during the
     * booking process.
     */
    public function new()
    {
        session(['dest_url' => site_url('new')]);

        $user_id = session('user_id');

        if (cannot('view', PRIV_CUSTOMERS)) {
            if ($user_id) {
                abort(403, 'Forbidden');
            }

            redirect('login');

            return;
        }

        $role_slug = session('role_slug');

        script_vars([
            'user_id'             => $user_id,
            'role_slug'           => $role_slug,
            'timezones'           => $this->timezones->to_array(),
            'min_password_length' => MIN_PASSWORD_LENGTH,
            'services'           => array(),
        ]);

        html_vars([
            'page_title'        => lang('Package'),
            'active_menu'       => PRIV_USERS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
            'grouped_timezones' => $this->timezones->to_grouped_array(),
            'privileges'        => $this->roles_model->get_permissions_by_slug($role_slug),
        ]);

        $this->load->view('pages/package_form');
    }


    /**
     * Store a package.
     */
    public function store()
    {
        try {

            $user_id = session('user_id');

            if (cannot('view', PRIV_CUSTOMERS)) {
                if ($user_id) {
                    abort(403, 'Forbidden');
                }

                redirect('login');

                return;
            }

            $this->db->trans_begin();

            $package = request('package');

            $provider_id = $this->packages_model->save($user_id, $package);

            $provider = $this->providers_model->find($provider_id);

            $this->webhooks_client->trigger(WEBHOOK_PROVIDER_SAVE, $provider);

            $this->db->trans_complete();
            json_response([
                'success' => TRUE,
                'id'      => $provider_id,
            ]);
        } catch (Throwable $e) {
            json_exception($e);
            $this->db->trans_complete();
        }
    }
}
