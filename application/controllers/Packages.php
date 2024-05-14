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
     * Render the backend providers page.
     *
     * On this page admin users will be able to manage providers, which are eventually selected by customers during the
     * booking process.
     */
    public function index()
    {
        session(['dest_url' => site_url('providers')]);

        $user_id = session('user_id');

        if (cannot('view', PRIV_CUSTOMERS)) {
            if ($user_id) {
                abort(403, 'Forbidden');
            }

            redirect('login');

            return;
        }

        $role_slug = session('role_slug');
        $privileges = $this->roles_model->get_permissions_by_slug($role_slug);

        $services = $this->services_model->get_secretary_services(secretary_id: $user_id);

        foreach ($services as &$service) {
            $this->services_model->only($service, ['id', 'name']);
        }

        $keyword = request('keyword', '');

        $order_by = 'update_datetime DESC';

        $limit = request('limit', 1000);

        $offset = 0;
        if (cannot('view', PRIV_USERS)) {
            $providers = $this->providers_model->search($keyword, $limit, $offset, $order_by, $user_id);
        } else {

            $providers = $this->providers_model->search($keyword, $limit, $offset, $order_by);
        }

        script_vars([
            'user_id'              => $user_id,
            'role_slug'            => $role_slug,
            'company_working_plan' => setting('company_working_plan'),
            'date_format'          => setting('date_format'),
            'time_format'          => setting('time_format'),
            'first_weekday'        => setting('first_weekday'),
            'min_password_length'  => MIN_PASSWORD_LENGTH,
            'timezones'            => $this->timezones->to_array(),
            'services'             => $services,
            'privileges' => $privileges,
            'providers' => $providers
        ]);

        html_vars([
            'page_title'        => lang('providers'),
            'active_menu'       => PRIV_USERS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
            'grouped_timezones' => $this->timezones->to_grouped_array(),
            'privileges'        => $privileges,
            'services'          => $services,
            'providers' => $providers
        ]);

        $this->load->view('pages/packages');
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
        $privileges = $this->roles_model->get_permissions_by_slug($role_slug);

        $keyword = request('keyword', '');

        $order_by = 'update_datetime DESC';

        $limit = request('limit', 1000);

        $offset = 0;

        $categories = $this->service_categories_model->search($keyword, $limit, $offset, $order_by);

        script_vars([
            'user_id'             => $user_id,
            'role_slug'           => $role_slug,
            'services'           => array(),
            'privileges' => $privileges,
            "categories" => $categories,
        ]);

        html_vars([
            'page_title'        => lang('Package'),
            'active_menu'       => PRIV_CUSTOMERS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
            'privileges'        => $privileges,
        ]);

        $this->load->view('pages/package_form');
    }

    public function edit($provider_id)
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

        // TODO: move to package model
        if (can('view', PRIV_USERS)) {
            $provider = $this->providers_model->find($provider_id);
            $this->providers_model->load($provider, ["services"]);
        } else {
            // check if secretary owns provider
            if (!$this->secretaries_model->has_provider($user_id, $provider_id)) {
                abort(403, 'Forbidden');
            }
            $provider = $this->providers_model->find($provider_id);
            $this->providers_model->load($provider, ["services"]);
        }

        $role_slug = session('role_slug');
        $privileges = $this->roles_model->get_permissions_by_slug($role_slug);

        $keyword = request('keyword', '');

        $order_by = 'update_datetime DESC';

        $limit = request('limit', 1000);

        $offset = 0;

        $categories = $this->service_categories_model->search($keyword, $limit, $offset, $order_by);

        // convert provider format to survey form
        $package = array();
        $parts = explode("|", $provider['first_name']);
        $name = end($parts);
        $package["package_name"] = $name;
        $package["package_description"] = $provider["notes"];
        $package["package_image"] = $provider["settings"]["image"];
        // TODO: package api_decode

        if (array_key_exists('working_plan', $provider['settings'])) {
            $provider['settings']['working_plan'] = json_decode($provider['settings']['working_plan']);
        }
        $working_plan_start_time = [];
        $working_plan_stop_time = [];
        $package["id"] = $provider["id"];
        foreach ($provider["settings"]["working_plan"] as $day => $time) {
            switch ($day) {
                case 'monday':
                    $name = "text1";
                    break;
                case 'tuesday':
                    $name = "text2";
                    break;
                case 'wednesday':
                    $name = "text3";
                    break;
                case 'thursday':
                    $name = "text4";
                    break;
                case 'friday':
                    $name = "text5";
                    break;
                case 'saturday':
                    $name = "text6";
                    break;
                case 'sunday':
                    $name = "text7";
                    break;
                default:
                    break;
            }
            $working_plan_start_time[$name] = $time->start;
            $working_plan_stop_time[$name] = $time->end;
        }
        $package["working_plan"] = [array(
            "working_plan_start_time" => $working_plan_start_time,
            "working_plan_stop_time" => $working_plan_stop_time
        )];

        $service_details = [];
        foreach ($provider["services"] as $service) {
            $srv = array();
            $srv["service_name"] = $service["name"];
            $srv["duration"] = (int)$service["duration"];
            $srv["price"] = (int)$service["price"];
            $srv["fee"] =  (int)$service["fee"];
            $srv["currency"] = $service["currency"];
            $srv["attendants_number"] = (int)$service["attendants_number"];
            $srv["service_description"] = $service["description"];
            $srv["event_location"] = $service["location"];
            $srv["service_image"] = [array("content" => $service["image"])];
            $srv["service_category"] = (int)$service["id_service_categories"];
            $srv["availabilities_type"] = $service["availabilities_type"];
            array_push($service_details, array(
                "id" => $service["id"],
                "service_details" => $srv,
                "service_image" => $srv["service_image"],
                "service_category" => $srv["service_category"]
            ));
        }
        $package["services"] = $service_details;

        script_vars([
            'user_id'             => $user_id,
            'role_slug'           => $role_slug,
            'services'           => array(),
            'privileges' => $privileges,
            "categories" => $categories,
            'package' => $package
        ]);

        html_vars([
            'page_title'        => lang('Package'),
            'active_menu'       => PRIV_CUSTOMERS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
            'privileges'        => $privileges,
            'package' => $package,
            "categories" => $categories,
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


            // TODO: move to package model
            if (cannot('view', PRIV_USERS)) {
                // check if secretary owns provider
                if (!$this->secretaries_model->has_provider($user_id, $package["id"])) {
                    abort(403, 'Forbidden');
                }
            }

            $provider_id = $this->packages_model->save($user_id, $package);

            $provider = $this->providers_model->find($provider_id);

            $this->db->trans_complete();
            $this->webhooks_client->trigger(WEBHOOK_PROVIDER_SAVE, $provider);

            json_response([
                'success' => TRUE,
                'id'      => $provider_id,
            ]);
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            json_exception($e);
        }
    }
    /**
     * Store a package.
     */
    public function update()
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

            $this->db->trans_complete();
            $this->webhooks_client->trigger(WEBHOOK_PROVIDER_SAVE, $provider);

            json_response([
                'success' => TRUE,
                'id'      => $provider_id,
            ]);
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            json_exception($e);
        }
    }
}
