<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Add_fee_bearer_field_to_services_table extends CI_Migration
{
    /**
     * Upgrade method.
     */
    public function up()
    {
        if (!$this->db->field_exists('fee_bearer', 'services')) {
            $fields = [
                'fee_bearer' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
            ];

            $this->dbforge->add_column('services', $fields);
        }
    }

    /**
     * Downgrade method.
     */
    public function down()
    {
        if ($this->db->field_exists('fee_bearer', 'services')) {
            $this->dbforge->drop_column('services', 'fee_bearer');
        }
    }
}
