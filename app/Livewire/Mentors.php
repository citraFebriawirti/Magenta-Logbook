<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mentor;
use App\Models\UnitKerjaModel;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class Mentors extends Component
{
    use WithPagination;

    public $nama_mentor = '';
    public $jabatan_mentor = '';
    public $id_users = null;
    public $id_unit_kerja = null;
    public $mentors;
    public $edit_id = null;
    public $is_edit_mode = false;

    protected $rules = [
        'nama_mentor' => 'required|string|max:255',
        'jabatan_mentor' => 'required|string|max:255',
        'id_users' => 'nullable|exists:users,id',
        'id_unit_kerja' => 'nullable|exists:tb_unit_kerja,id_unit_kerja',
    ];

    protected $messages = [
        'nama_mentor.required' => 'Nama mentor wajib diisi.',
        'nama_mentor.string' => 'Nama mentor harus berupa teks.',
        'nama_mentor.max' => 'Nama mentor tidak boleh lebih dari 255 karakter.',
        'jabatan_mentor.required' => 'Jabatan mentor wajib diisi.',
        'jabatan_mentor.string' => 'Jabatan mentor harus berupa teks.',
        'jabatan_mentor.max' => 'Jabatan mentor tidak boleh lebih dari 255 karakter.',
        'id_users.exists' => 'Pengguna yang dipilih tidak valid.',
        'id_unit_kerja.exists' => 'Unit kerja yang dipilih tidak valid.',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->mentors = Mentor::where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store()
    {
        try {
            $this->validate();

            Mentor::create([
                'nama_mentor' => $this->nama_mentor,
                'jabatan_mentor' => $this->jabatan_mentor,
                'id_users' => $this->id_users,
                'id_unit_kerja' => $this->id_unit_kerja,
                'created_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data mentor berhasil disimpan!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_mentor'][0] ?? $e->errors()['jabatan_mentor'][0] ?? 'Validasi gagal.'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ]);
        }
    }

    public function apiStore(Request $request)
    {
        try {
            $validated = $this->validateRequest($request, [
                'nama_mentor' => 'required|string|max:255',
                'jabatan_mentor' => 'required|string|max:255',
                'id_users' => 'nullable|exists:users,id',
                'id_unit_kerja' => 'nullable|exists:tb_unit_kerja,id_unit_kerja',
            ]);

            $mentor = Mentor::create([
                'nama_mentor' => $validated['nama_mentor'],
                'jabatan_mentor' => $validated['jabatan_mentor'],
                'id_users' => $validated['id_users'] ?? null,
                'id_unit_kerja' => $validated['id_unit_kerja'] ?? null,
                'created_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data mentor berhasil disimpan',
                'errors' => [],
                'data' => $mentor,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
                'errors' => [],
                'data' => [],
            ]);
        }
    }

    public function apiGetAll()
    {
        try {
            $data = Mentor::where('deleted_at', null)->get();
            return response()->json([
                'status' => 200,
                'message' => 'Data mentor berhasil diambil',
                'errors' => [],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
                'errors' => [],
                'data' => [],
            ]);
        }
    }

    public function apiGetById($id)
    {
        try {
            $data = Mentor::findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Data mentor berhasil diambil',
                'errors' => [],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
                'errors' => [],
                'data' => [],
            ]);
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        try {
            $validated = $this->validateRequest($request, [
                'nama_mentor' => 'required|string|max:255',
                'jabatan_mentor' => 'required|string|max:255',
                'id_users' => 'nullable|exists:users,id',
                'id_unit_kerja' => 'nullable|exists:tb_unit_kerja,id_unit_kerja',
            ]);

            Mentor::where('id_mentor', $id)->update([
                'nama_mentor' => $validated['nama_mentor'],
                'jabatan_mentor' => $validated['jabatan_mentor'],
                'id_users' => $validated['id_users'] ?? null,
                'id_unit_kerja' => $validated['id_unit_kerja'] ?? null,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data mentor berhasil diupdate',
                'errors' => [],
                'data' => $request->all(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
                'errors' => [],
                'data' => [],
            ]);
        }
    }

    public function apiDelete($id)
    {
        try {
            Mentor::where('id_mentor', $id)->update(['deleted_at' => now()]);
            return response()->json([
                'status' => 200,
                'message' => 'Data mentor berhasil dihapus',
                'errors' => [],
                'data' => [],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
                'errors' => [],
                'data' => [],
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $mentor = Mentor::findOrFail($id);
            $this->nama_mentor = $mentor->nama_mentor;
            $this->jabatan_mentor = $mentor->jabatan_mentor;
            $this->id_users = $mentor->id_users;
            $this->id_unit_kerja = $mentor->id_unit_kerja;
            $this->edit_id = $id;
            $this->is_edit_mode = true;
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal mengambil data: ' . $th->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->validate();

            Mentor::where('id_mentor', $this->edit_id)->update([
                'nama_mentor' => $this->nama_mentor,
                'jabatan_mentor' => $this->jabatan_mentor,
                'id_users' => $this->id_users,
                'id_unit_kerja' => $this->id_unit_kerja,
                'updated_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data mentor berhasilタリアップデート!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_mentor'][0] ?? $e->errors()['jabatan_mentor'][0] ?? 'Validasi gagal.'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Mentor::where('id_mentor', $id)->update(['deleted_at' => now()]);
            session()->flash('message', 'Data mentor berhasil dihapus');
            $this->loadData();
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function resetForm()
    {
        $this->nama_mentor = '';
        $this->jabatan_mentor = '';
        $this->id_users = null;
        $this->id_unit_kerja = null;
        $this->edit_id = null;
        $this->is_edit_mode = false;
    }

    protected function validateRequest(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules, $this->messages);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function render()
    {
        return view('livewire.mentor')->extends('layout.layouts');
    }
}
