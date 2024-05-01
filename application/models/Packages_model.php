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

        if (empty($secretary['id'])) {
            return $this->insert($user_id, $package);
        } else {
            return $this->update($package);
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

        $provider = array_merge($account, []);
        $username = slugify($package['package_name']);
        $provider['notes'] = $package["package_description"];
        $provider["first_name"] = $secretary["first_name"] . ' ' . $secretary["last_name"];
        $provider["last_name"] = ' | ' . $package['package_name'];
        $provider["email"] = insert_after_char($account["email"], '+' . $username, "@");
        $provider['settings']["username"] = $account["settings"]["username"] . '_' . $username;

        if (is_array($package["package_image"])) {
            $provider["settings"]['image'] = $package["package_image"][0]["content"];
        }

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
        foreach ($package["services"] as $service) {
            if (is_array($service["service_image"])) {
                $image = $service["service_image"][0]["content"];
            }
            $service = [
                'name'               => $provider["first_name"] . $provider["last_name"] . ' | ' . $service["service_details"]["service_name"],
                'duration'           => $service["service_details"]["duration"],
                'price'              => $service["service_details"]["price"],
                'currency'           => 'NGN',
                'attendants_number'   => 1,
                'description'        => $service["service_details"]['service_description'],
                'location'           => $service["service_details"]['event_location'],
                'id_service_categories'  => $service["service_details"]['service_category'],
                'image'              => $image,
            ];
            $service_id = $this->services_model->save($service);
            array_push($services, $service_id);
        }

        $this->providers_model->optional($provider, [
            'services' => [],
        ]);
        $provider_id = $this->providers_model->save($provider, true);
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
    protected function update(array $secretary): int
    {
        return -1;
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
        $this->db->delete('secretaries_providers', ['id_users_secretary' => $secretary_id]);

        foreach ($provider_ids as $provider_id) {
            $secretary_provider_connection = [
                'id_users_secretary' => $secretary_id,
                'id_users_provider' => $provider_id,
            ];

            $this->db->insert('secretaries_providers', $secretary_provider_connection);
        }
    }
}
