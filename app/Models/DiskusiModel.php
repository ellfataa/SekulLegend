<?php

namespace App\Models;

use CodeIgniter\Model;

class DiskusiModel extends Model
{
    protected $table = 'diskusi_kelas';
    protected $allowedFields = ['id_kelas', 'id_user', 'pesan', 'created_at'];
}
