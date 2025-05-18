<?php

namespace App\Controllers;

use App\Models\MateriModel;
use App\Models\KelasModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Materi extends BaseController
{
    public function index($id_kelas)
    {
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();

        $kelas = $kelasModel->find($id_kelas);

        if (!$kelas) {
            throw PageNotFoundException::forPageNotFound("Kelas tidak ditemukan.");
        }

        $materi = $materiModel->where('id_kelas', $id_kelas)->findAll();

        return view('materi/index', [
            'kelas' => $kelas,
            'materi' => $materi
        ]);
    }

    public function edit($id)
    {
        $materiModel = new MateriModel();
        $materi = $materiModel->find($id);

        if (!$materi) {
            throw PageNotFoundException::forPageNotFound('Materi tidak ditemukan.');
        }

        return view('materi/edit', ['materi' => $materi]);
    }

    public function update($id)
    {
        $materiModel = new MateriModel();
        $materiLama = $materiModel->find($id);

        if (!$materiLama) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        if (!$judul || !$deskripsi) {
            return redirect()->back()->with('error', 'Judul dan Deskripsi wajib diisi.');
        }

        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
        ];

        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/uploads/materi', $newName);

            // Hapus file lama jika ada
            if (!empty($materiLama['file'])) {
                @unlink('public/uploads/materi' . $materiLama['file']);
            }

            $data['file'] = $newName;
        }

        $materiModel->update($id, $data);

        return redirect()
            ->to('/materi/kelas/' . $materiLama['id_kelas'])
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $materiModel = new MateriModel();
        $materi = $materiModel->find($id);

        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }

        if (!empty($materi['file'])) {
            @unlink('public/uploads/materi' . $materi['file']);
        }

        $materiModel->delete($id);

        return redirect()
            ->to('/materi/kelas/' . $materi['id_kelas'])
            ->with('success', 'Materi berhasil dihapus.');
    }

    public function download($filename)
    {
        $filepath = WRITEPATH . '../public/uploads/materi' . $filename;

        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan.');
        }

        return $this->response->download($filepath, null);
    }

    public function simpanMateri()
    {
        $materiModel = new MateriModel();

        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('public/uploads/materi', $fileName);
        }

        $materiModel->save([
            'id_kelas' => $this->request->getPost('id_kelas'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName
        ]);

        return redirect()->to('/kelas')->with('success', 'Materi berhasil ditambahkan.');
    }

}
