<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      F.González <frnd@tuta.io>
 * @copyright   Copyright (c) 2013 - 2020, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_account_details_to_user_settings_table extends CI_Migration
{
    /**
     * Upgrade method.
     */
    public function up()
    {
        if (!$this->db->field_exists('bank_name', 'user_settings')) {
            $fields = [
                'account_number' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'bank_name' => [
                    'type' => 'TEXT',
                    'null' => true
                ]
            ];

            $this->dbforge->add_column('user_settings', $fields);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ($this->db->field_exists('bank_name', 'user_settings')) {
            $this->dbforge->drop_column('user_settings', 'bank_name');
            $this->dbforge->drop_column('user_settings', 'account_number');
        }
    }
}
