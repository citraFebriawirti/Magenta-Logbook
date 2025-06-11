<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use Livewire\WithPagination;

class Kegiatans extends Component
{
    use WithPagination;

    public $id_peserta, $tanggal_mulai_kegiatan, $tanggal_selesai_kegiatan, $deskripsi_kegiatan,
        $progres_kegiatan, $keterangan_kegiatan, $status_kegiatan = 'draft', $catatan_pembimbing;

    public $kegiatans;
    public $edit_id = null;
    public $is_edit_mode = false;

    protected $rules = [
        'tanggal_mulai_kegiatan' => 'required|date',
        'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
        'deskripsi_kegiatan' => 'nullable|string',
        'progres_kegiatan' => 'nullable|integer|min:0|max:100',
        'keterangan_kegiatan' => 'nullable|string',
        'status_kegiatan' => 'in:draft,submitted,validated,rejected',
        'catatan_pembimbing' => 'nullable|string',
    ];

    protected $messages = [
        'tanggal_mulai_kegiatan.required' => 'Tanggal mulai wajib diisi.',
        'tanggal_selesai_kegiatan.required' => 'Tanggal selesai wajib diisi.',
        'tanggal_selesai_kegiatan.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->kegiatans = Kegiatan::whereNull('deleted_at')->orderByDesc('created_at')->get();
    }

    public function store()
    {
        try {
            $this->validate();

            Kegiatan::create([
                'id_peserta' => $this->id_peserta,
                'tanggal_mulai_kegiatan' => $this->tanggal_mulai_kegiatan,
                'tanggal_selesai_kegiatan' => $this->tanggal_selesai_kegiatan,
                'deskripsi_kegiatan' => $this->deskripsi_kegiatan,
                'progres_kegiatan' => $this->progres_kegiatan,
                'keterangan_kegiatan' => $this->keterangan_kegiatan,
                'status_kegiatan' => $this->status_kegiatan,
                'catatan_pembimbing' => $this->catatan_pembimbing,
                'created_at' => now(),
            ]);

            $this->dispatch('showAlert', ['type' => 'success', 'message' => 'Data berhasil disimpan!']);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_peserta' => 'required|integer',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'deskripsi_kegiatan' => 'nullable|string',
            'progres_kegiatan' => 'nullable|integer|min:0|max:100',
            'keterangan_kegiatan' => 'nullable|string',
            'status_kegiatan' => 'required|in:draft,submitted,validated,rejected',
            'catatan_pembimbing' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = Kegiatan::create($request->all());

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $data]);
    }

    public function apiGetAll()
    {
        $data = Kegiatan::whereNull('deleted_at')->orderByDesc('created_at')->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);

            $this->edit_id = $id;
            $this->id_peserta = $kegiatan->id_peserta;
            $this->tanggal_mulai_kegiatan = $kegiatan->tanggal_mulai_kegiatan;
            $this->tanggal_selesai_kegiatan = $kegiatan->tanggal_selesai_kegiatan;
            $this->deskripsi_kegiatan = $kegiatan->deskripsi_kegiatan;
            $this->progres_kegiatan = $kegiatan->progres_kegiatan;
            $this->keterangan_kegiatan = $kegiatan->keterangan_kegiatan;
            $this->status_kegiatan = $kegiatan->status_kegiatan;
            $this->catatan_pembimbing = $kegiatan->catatan_pembimbing;
            $this->is_edit_mode = true;
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal mengambil data: ' . $th->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->validate();

            Kegiatan::where('id_kegiatan', $this->edit_id)->update([
                'id_peserta' => $this->id_peserta,
                'tanggal_mulai_kegiatan' => $this->tanggal_mulai_kegiatan,
                'tanggal_selesai_kegiatan' => $this->tanggal_selesai_kegiatan,
                'deskripsi_kegiatan' => $this->deskripsi_kegiatan,
                'progres_kegiatan' => $this->progres_kegiatan,
                'keterangan_kegiatan' => $this->keterangan_kegiatan,
                'status_kegiatan' => $this->status_kegiatan,
                'catatan_pembimbing' => $this->catatan_pembimbing,
                'updated_at' => now(),
            ]);

            $this->dispatch('showAlert', ['type' => 'success', 'message' => 'Data berhasil diupdate!']);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = Kegiatan::find($id);

        if (!$data || $data->deleted_at) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_peserta' => 'required|integer',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'deskripsi_kegiatan' => 'nullable|string',
            'progres_kegiatan' => 'nullable|integer|min:0|max:100',
            'keterangan_kegiatan' => 'nullable|string',
            'status_kegiatan' => 'required|in:draft,submitted,validated,rejected',
            'catatan_pembimbing' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data->update($request->all());

        return response()->json(['success' => true, 'message' => 'Data berhasil diupdate', 'data' => $data]);
    }

    public function delete($id)
    {
        try {
            Kegiatan::where('id_kegiatan', $id)->update(['deleted_at' => now()]);
            session()->flash('message', 'Data berhasil dihapus');
            $this->loadData();
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function apiDelete($id)
    {
        $data = Kegiatan::find($id);

        if (!$data || $data->deleted_at) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->update(['deleted_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function resetForm()
    {
        $this->id_peserta = null;
        $this->tanggal_mulai_kegiatan = null;
        $this->tanggal_selesai_kegiatan = null;
        $this->deskripsi_kegiatan = null;
        $this->progres_kegiatan = null;
        $this->keterangan_kegiatan = null;
        $this->status_kegiatan = 'draft';
        $this->catatan_pembimbing = null;
        $this->edit_id = null;
        $this->is_edit_mode = false;
    }

    public function render()
    {
        return view('livewire.kegiatan')->extends('layout.layouts');
    }
}