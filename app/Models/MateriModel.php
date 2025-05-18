<?php

namespace App\Models;
use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table = 'materi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi', 'file', 'id_kelas', 'created_at'];
    protected $useTimestamps = true;
}
