<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaKelasModel extends Model
{
    protected $table            = 'siswa_kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_user',
        'id_kelas',
    ];

    public function getKelasBySiswa($idUser): array
    {
        return $this->select('kelas.*')
            ->join('kelas', 'kelas.id = siswa_kelas.id_kelas')
            ->where('siswa_kelas.id_user', $idUser)
            ->orderBy('kelas.id', 'DESC')
            ->findAll();
    }

    public function countKelasBySiswa($idUser): int
    {
        return $this->where('id_user', $idUser)
            ->countAllResults();
    }

    public function isSiswaJoined($idUser, $idKelas): bool
    {
        return $this->where('id_user', $idUser)
            ->where('id_kelas', $idKelas)
            ->first() !== null;
    }
}