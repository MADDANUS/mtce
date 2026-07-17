<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUserRoles extends Migration
{
    public function up()
    {
        // Change to VARCHAR instead of ENUM to prevent rigid database errors
        $this->db->query("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'magang'");
        
        $this->db->query("UPDATE users SET role = 'magang' WHERE role = 'staff' OR role = ''");
        $this->db->query("UPDATE users SET role = 'member' WHERE role = 'leader'");
    }

    public function down()
    {
        // Revert back
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'leader', 'staff') DEFAULT 'staff'");
        $this->db->query("UPDATE users SET role = 'staff' WHERE role = 'magang'");
        $this->db->query("UPDATE users SET role = 'leader' WHERE role = 'member'");
    }
}
