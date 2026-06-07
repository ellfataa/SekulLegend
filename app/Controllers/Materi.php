<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MateriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Materi extends BaseController
{
    private string $materiUploadPath = FCPATH . 'uploads/materi';

    private function ensureGuru()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login sebagai guru terlebih dahulu.');
        }

        return null;
    }

    private function getOwnedKelas(int $idKelas): ?array
    {
        $kelasModel = new KelasModel();

        return $kelasModel
            ->where('id', $idKelas)
            ->where('id_guru', session()->get('id'))
            ->first();
    }

    private function getOwnedMateri(int $idMateri): ?array
    {
        $materiModel = new MateriModel();

        $materi = $materiModel->find($idMateri);

        if (! $materi) {
            return null;
        }

        $kelas = $this->getOwnedKelas((int) $materi['id_kelas']);

        if (! $kelas) {
            return null;
        }

        return $materi;
    }

    private function ensureUploadDirectory(): void
    {
        if (! is_dir($this->materiUploadPath)) {
            mkdir($this->materiUploadPath, 0775, true);
        }
    }

    public function index($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            throw PageNotFoundException::forPageNotFound('Kelas tidak ditemukan.');
        }

        $materiModel = new MateriModel();

        $materi = $materiModel
            ->where('id_kelas', $idKelas)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('materi/index', [
            'kelas'  => $kelas,
            'materi' => $materi,
        ]);
    }

    public function edit($id)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $materi = $this->getOwnedMateri((int) $id);

        if (! $materi) {
            throw PageNotFoundException::forPageNotFound('Materi tidak ditemukan.');
        }

        return view('materi/edit', [
            'materi' => $materi,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $materi = $this->getOwnedMateri((int) $id);

        if (! $materi) {
            return redirect()
                ->back()
                ->with('error', 'Materi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi Materi',
                'rules' => 'permit_empty|max_length[1000]',
            ],
            'file' => [
                'label' => 'File Materi',
                'rules' => 'permit_empty|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx,xls,xlsx]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'judul'     => trim((string) $this->request->getPost('judul')),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
        ];

        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $this->ensureUploadDirectory();

            $newName = $file->getRandomName();
            $file->move($this->materiUploadPath, $newName);

            if (! empty($materi['file'])) {
                $oldFilePath = $this->materiUploadPath . '/' . $materi['file'];

                if (is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $data['file'] = $newName;
        }

        $materiModel = new MateriModel();
        $materiModel->update($id, $data);

        return redirect()
            ->to('/materi/kelas/' . $materi['id_kelas'])
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function hapus($id)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $materi = $this->getOwnedMateri((int) $id);

        if (! $materi) {
            return redirect()
                ->back()
                ->with('error', 'Materi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if (! empty($materi['file'])) {
            $filePath = $this->materiUploadPath . '/' . $materi['file'];

            if (is_file($filePath)) {
                unlink($filePath);
            }
        }

        $materiModel = new MateriModel();
        $materiModel->delete($id);

        return redirect()
            ->to('/materi/kelas/' . $materi['id_kelas'])
            ->with('success', 'Materi berhasil dihapus.');
    }

    public function download($filename)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $filename = basename($filename);
        $filePath = $this->materiUploadPath . '/' . $filename;

        if (! is_file($filePath)) {
            throw PageNotFoundException::forPageNotFound('File tidak ditemukan.');
        }

        return $this->response->download($filePath, null);
    }
}