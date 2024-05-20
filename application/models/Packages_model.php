<?php defined('BASEPATH') or exit('No direct script access allowed');

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
 * Packages model.
 *
 * Handles all the database operations of the secretary resource.
 *
 * @package Models
 */
class Packages_model extends EA_Model
{
    /**
     * @var array
     */
    protected array $casts = [
        'id' => 'integer',
        'id_roles' => 'integer',
    ];

    /**
     * @var array
     */
    protected array $api_resource = [
        'id' => 'id',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'email' => 'email',
        'mobile' => 'mobile_number',
        'phone' => 'phone_number',
        'address' => 'address',
        'city' => 'city',
        'state' => 'state',
        'zip' => 'zip_code',
        'timezone' => 'timezone',
        'language' => 'language',
        'notes' => 'notes',
        'roleId' => 'id_roles',
    ];

    /**
     * Save (insert or update) a secretary.
     *
     * @param array $secretary Associative array with the secretary data.
     *
     * @return int Returns the secretary ID.
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function save($user_id, array $package): int
    {

        if (empty($package['id'])) {
            return $this->insert($user_id, $package);
        } else {
            return $this->update($user_id, $package);
        }
    }


    /**
     * Validate the secretary username.
     *
     * @param string $username Secretary username.
     * @param int|null $secretary_id Secretary ID.
     *
     * @return bool Returns the validation result.
     */
    public function validate_username(string $username, int $secretary_id = null): bool
    {
        if (!empty($secretary_id)) {
            $this->db->where('id_users !=', $secretary_id);
        }

        return $this->db
            ->from('users')
            ->join('user_settings', 'user_settings.id_users = users.id', 'inner')
            ->where(['username' => $username])
            ->get()
            ->num_rows() === 0;
    }

    /**
     * Get all secretaries that match the provided criteria.
     *
     * @param array|string|null $where Where conditions
     * @param int|null $limit Record limit.
     * @param int|null $offset Record offset.
     * @param string|null $order_by Order by.
     *
     * @return array Returns an array of secretaries.
     */
    public function get(
        array|string $where = null,
        int $limit = null,
        int $offset = null,
        string $order_by = null,
    ): array {
        $role_id = $this->get_secretary_role_id();

        if ($where !== null) {
            $this->db->where($where);
        }

        if ($order_by !== null) {
            $this->db->order_by($order_by);
        }

        $secretaries = $this->db->get_where('users', ['id_roles' => $role_id], $limit, $offset)->result_array();

        foreach ($secretaries as &$secretary) {
            $secretary['settings'] = $this->db
                ->get_where('user_settings', ['id_users' => $secretary['id']])
                ->row_array();

            unset(
                $secretary['settings']['id_users'],
                $secretary['settings']['password'],
                $secretary['settings']['salt'],
            );

            $secretary_provider_connections = $this->db
                ->get_where('secretaries_providers', ['id_users_secretary' => $secretary['id']])
                ->result_array();

            $secretary['providers'] = [];

            foreach ($secretary_provider_connections as $secretary_provider_connection) {
                $secretary['providers'][] = (int) $secretary_provider_connection['id_users_provider'];
            }
        }

        return $secretaries;
    }

    /**
     * Get the secretary role ID.
     *
     * @return int Returns the role ID.
     */
    public function get_secretary_role_id(): int
    {
        $role = $this->db->get_where('roles', ['slug' => DB_SLUG_SECRETARY])->row_array();

        if (empty($role)) {
            throw new RuntimeException('The secretary role was not found in the database.');
        }

        return $role['id'];
    }

    /**
     * Insert a new secretary into the database.
     *
     * @param array $secretary Associative array with the secretary data.
     *
     * @return int Returns the secretary ID.
     *
     * @throws RuntimeException|Exception
     */
    protected function insert(int $user_id, array $package): int
    {
        $this->load->model('Users_model');
        $this->load->model('Secretaries_model');
        $this->load->model('Providers_model');
        $this->load->model('Services_model');

        $account = $this->users_model->find($user_id, $skipUnset = true);
        $secretary = $this->secretaries_model->find($user_id);
        $package_name = trim($package['package_name']);

        $provider = array_merge($account, []);
        $username = slugify($package_name);
        $provider['notes'] = $package["package_description"];
        $provider["first_name"] = $secretary["first_name"] . ' ' . $secretary["last_name"];
        $provider["last_name"] = ' | ' . $package_name;
        $provider["email"] = insert_after_char($account["email"], '+' . $username, "@");
        $provider['settings']["username"] = $account["settings"]["username"] . '_' . $username;

        if (array_key_exists("package_image", $package)) {
            $provider["settings"]['image'] = $package["package_image"][0]["content"];
        }

        $working_plans = [];
        foreach ($package["working_plan"] as $wp) {
            foreach ($wp["working_plan_start_time"] as $day => $time) {
                $name = "";
                $end_time = $wp["working_plan_stop_time"][$day];
                switch ($day) {
                    case 'text1':
                        $name = "monday";
                        break;
                    case 'text2':
                        $name = "tuesday";
                        break;
                    case 'text3':
                        $name = "wednesday";
                        break;
                    case 'text4':
                        $name = "thursday";
                        break;
                    case 'text5':
                        $name = "friday";
                        break;
                    case 'text6':
                        $name = "saturday";
                        break;
                    case 'text7':
                        $name = "sunday";
                        break;
                    default:
                        break;
                }
                $breaks = [];
                if (array_key_exists("breaks", $package)) {
                    foreach ($package["breaks"] as $wpb) {
                        array_push($breaks, array(
                            "start" => $wpb["break_start_time"][$day],
                            "end" => $wpb["break_time_stop_time"][$day]
                        ));
                    };
                }
                $working_plans[$name] = array(
                    "start" => $time,
                    "end" =>  $end_time,
                    "breaks" => $breaks,
                );
            }
        }
        $provider['settings']["working_plan"] = json_encode($working_plans);

        $this->providers_model->only($provider, [
            'first_name',
            'last_name',
            'email',
            'alt_number',
            'phone_number',
            'address',
            'city',
            'state',
            'zip_code',
            'notes',
            'timezone',
            'language',
            'is_private',
            'id_roles',
            'settings',
            'services'
        ]);

        $this->providers_model->only($provider['settings'], [
            'username',
            'password',
            'salt',
            'bank_name',
            'account_number',
            'working_plan',
            'working_plan_exceptions',
            'notifications',
            'calendar_view',
            "image"
        ]);

        $services = [];
        $image = NULL;
        if (array_key_exists("services", $package)) {
            foreach ($package["services"] as $ss) {
                if (array_key_exists("service_details", $ss) && is_array($ss["service_details"])) {
                    if (array_key_exists("service_image", $ss) && is_array($ss["service_image"])) {
                        $image = $ss["service_image"][0]["content"];
                    }

                    if (array_key_exists("attendants_number", $ss["service_details"])) {
                        $attendants_number = (int)$ss["service_details"]["attendants_number"];
                    } else if (array_key_exists("attendants", $ss["service_details"])) {
                        $attendants_number = (int)$ss["service_details"]["attendants"];
                    } else {
                        $attendants_number = 1;
                    }
                    $service = [
                        'duration'           => array_key_exists("duration", $ss["service_details"]) ? $ss["service_details"]["duration"] : 60,
                        'price'              => array_key_exists("price", $ss["service_details"]) ? $ss["service_details"]["price"] : 0,
                        'currency'           => 'NGN',
                        'attendants_number'   => $attendants_number,
                        'location'           => array_key_exists("event_location", $ss["service_details"]) ? $ss["service_details"]['event_location'] : "",
                        'image'              => $image,
                        'availabilities_type' => array_key_exists("availabilities_type", $ss["service_details"]) ? $ss["service_details"]["availabilities_type"] : AVAILABILITIES_TYPE_FLEXIBLE
                    ];
                    if (array_key_exists("service_name", $ss["service_details"])) {
                        $service["name"] = $provider["first_name"] . $provider["last_name"] . ' | ' . $ss["service_details"]["service_name"];
                    }
                    if (array_key_exists("package_description", $ss)) {
                        $service["description"] = $ss["package_description"];
                    }
                    if (array_key_exists("service_category", $ss)) {
                        $service["id_service_categories"] = $ss["service_category"];
                    }

                    try {
                        $service_id = $this->services_model->save($service);
                    } catch (Exception $e) {
                        throw $e;
                    }
                    array_push($services, $service_id);
                }
            }
        }
        $provider["services"] = $services;
        $this->providers_model->optional($provider, [
            'services' => [],
        ]);
        $this->providers_model->optional($provider["settings"], [
            'bank_name' => '',
            'account_number' => '',
            'working_plan_exceptions' => '{}'
        ]);
        try {
            $provider_id = $this->providers_model->save($provider, true);
        } catch (InvalidArgumentException $e) {
            if (str_contains($e->getMessage(), "username is already in use")) {
                throw new InvalidArgumentException('A package with the same name already exists');
            }
            throw $e;
        }
        $this->save_provider_ids($user_id,  array_merge($secretary['providers'], [$provider_id]));
        return $provider_id;
    }


    /**
     * Update an existing secretary.
     *
     * @param array $secretary Associative array with the secretary data.
     *
     * @return int Returns the secretary ID.
     *
     * @throws RuntimeException|Exception
     */
    protected function update(int $user_id, array $package): int
    {

        $this->load->model('Users_model');
        $this->load->model('Secretaries_model');
        $this->load->model('Providers_model');
        $this->load->model('Services_model');
        if (empty($package["id"])) {
            throw new RuntimeException('Could not update package');
        }

        $provider_id = (int)$package["id"];
        $provider = $this->providers_model->find($provider_id);
        $package_name = trim($package['package_name']);
        $provider["id"] = $provider_id;
        $provider['notes'] = $package["package_description"];
        $provider["last_name"] = ' | ' . $package_name;
        if (array_key_exists("package_image", $package)) {
            if (is_array($package["package_image"])) {
                $provider["settings"]['image'] = $package["package_image"][0]["content"];
            } else {
                $provider["settings"]['image'] =  $package["package_image"];
            }
        }
        $username = slugify($package_name);
        $existing_username = $provider['settings']["username"];
        $first_underscore = strpos($existing_username, "_");
        $existing_username = ($first_underscore !== false) ? substr($existing_username, 0, $first_underscore) : $existing_username;
        $provider['settings']["username"] = $existing_username . '_' . $username;

        $working_plans = [];
        foreach ($package["working_plan"] as $wp) {
            foreach ($wp["working_plan_start_time"] as $day => $time) {
                $name = "";
                $end_time = $wp["working_plan_stop_time"][$day];
                switch ($day) {
                    case 'text1':
                        $name = "monday";
                        break;
                    case 'text2':
                        $name = "tuesday";
                        break;
                    case 'text3':
                        $name = "wednesday";
                        break;
                    case 'text4':
                        $name = "thursday";
                        break;
                    case 'text5':
                        $name = "friday";
                        break;
                    case 'text6':
                        $name = "saturday";
                        break;
                    case 'text7':
                        $name = "sunday";
                        break;
                    default:
                        break;
                }
                $breaks = [];
                if (array_key_exists("breaks", $package)) {
                    foreach ($package["breaks"] as $wpb) {
                        array_push($breaks, array(
                            "start" => $wpb["break_start_time"][$day],
                            "end" => $wpb["break_time_stop_time"][$day]
                        ));
                    };
                }
                $working_plans[$name] = array(
                    "start" => $time,
                    "end" =>  $end_time,
                    "breaks" => $breaks,
                );
            }
        }
        $provider['settings']["working_plan"] = json_encode($working_plans);

        $this->providers_model->only($provider, [
            'id',
            'first_name',
            'last_name',
            'email',
            'alt_number',
            'phone_number',
            'address',
            'city',
            'state',
            'zip_code',
            'notes',
            'timezone',
            'language',
            'is_private',
            'id_roles',
            'settings',
            'services'
        ]);

        $this->providers_model->only($provider['settings'], [
            'username',
            'password',
            'salt',
            'bank_name',
            'account_number',
            'working_plan',
            'working_plan_exceptions',
            'notifications',
            'calendar_view',
            "image"
        ]);

        $services = [];
        if (array_key_exists("services", $package)) {
            foreach ($package["services"] as $ss) {
                if (array_key_exists("service_details", $ss) && is_array($ss["service_details"])) {
                    if (array_key_exists("attendants_number", $ss["service_details"])) {
                        $attendants_number = (int)$ss["service_details"]["attendants_number"];
                    } else if (array_key_exists("attendants", $ss["service_details"])) {
                        $attendants_number = (int)$ss["service_details"]["attendants"];
                    } else {
                        $attendants_number = 1;
                    }
                    if (array_key_exists("availabilities_type", $ss)) {
                        $availabilities_type = $ss["availabilities_type"];
                    } else if (array_key_exists("availabilities_type", $ss["service_details"])) {
                        $availabilities_type = $ss["service_details"]["availabilities_type"];
                    } else {
                        $availabilities_type = "flexible";
                    }
                    $service = [
                        'name'               => $provider["first_name"] . $provider["last_name"] . ' | ' . trim($ss["service_details"]["service_name"]),
                        'duration'           => array_key_exists("duration", $ss["service_details"]) ? $ss["service_details"]["duration"] : 60,
                        'price'              => array_key_exists("price", $ss["service_details"]) ? $ss["service_details"]["price"] : 0,
                        'currency'           => 'NGN',
                        'attendants_number'   => $attendants_number,
                        'description'        => array_key_exists("service_description", $ss["service_details"]) ? $ss["service_details"]['service_description'] : "",
                        'location'           => array_key_exists("event_location", $ss["service_details"]) ? $ss["service_details"]['event_location'] : "",
                        'availabilities_type' => $availabilities_type
                    ];
                    if (array_key_exists("service_image", $ss) && is_array($ss["service_image"])) {
                        $service["image"] = $ss["service_image"][0]["content"];
                    }
                    if (!empty($ss['id'])) {
                        $service['id'] = $ss['id'];
                    }
                    if (array_key_exists("service_category", $ss)) {
                        $service["id_service_categories"] = $ss["service_category"];
                    }

                    try {
                        $service_id = $this->services_model->save($service);
                    } catch (Exception $e) {
                        throw $e;
                    }
                    array_push($services, $service_id);
                }
            }
        }
        $provider["services"] = $services;
        $this->providers_model->optional($provider, [
            'services' => [],
        ]);
        $this->providers_model->optional($provider["settings"], [
            'bank_name' => '',
            'account_number' => '',
            'working_plan_exceptions' => '{}'
        ]);
        try {
            $provider_id = $this->providers_model->save($provider, true);
        } catch (InvalidArgumentException $e) {
            if (str_contains($e->getMessage(), "username is already in use")) {
                throw new InvalidArgumentException('A package with the same name already exists');
            }
            throw $e;
        }
        // $this->save_provider_ids($user_id, $secretary['providers']);
        return $provider_id;
    }
    /**
     * Save the secretary provider IDs.
     *
     * @param int $secretary_id Secretary ID.
     * @param array $provider_ids Provider IDs.
     */
    protected function save_provider_ids(int $secretary_id, array $provider_ids)
    {
        // Re-insert the secretary-provider connections.
        if (!$this->db->delete('secretaries_providers', ['id_users_secretary' => $secretary_id])) {
            throw new RuntimeException('Could not update provider ids');
        }

        foreach ($provider_ids as $provider_id) {
            $secretary_provider_connection = [
                'id_users_secretary' => $secretary_id,
                'id_users_provider' => $provider_id,
            ];

            if (!$this->db->insert('secretaries_providers', $secretary_provider_connection)) {
                throw new RuntimeException('Could not update provider ids');
            }
        }
    }
}
