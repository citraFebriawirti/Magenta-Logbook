<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peserta;
use App\Models\User;
use App\Models\UnitKerja;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Pesertas extends Component
{
    use WithPagination;
    public $nama_peserta = '';
    public $id_user = null;
    public $id_unit_kerja = null;
    public $id_mentor = null;
    public $pesertas;
    public $edit_id = null;
    public $is_edit_mode = false;
    public $users;
    public $unit_kerjas;
    public $mentors;

    protected $rules = [
        'nama_peserta' => 'required|string|max:255',
        'id_user' => 'nullable|integer|exists:users,id',
        'id_unit_kerja' => 'nullable|integer|exists:tb_unit_kerja,id_unit_kerja',
        'id_mentor' => 'nullable|integer|exists:tb_mentor,id_mentor',
    ];

    protected $messages = [
        'nama_peserta.required' => 'Nama peserta wajib diisi.',
        'nama_peserta.string' => 'Nama peserta harus berupa teks.',
        'nama_peserta.max' => 'Nama peserta tidak boleh lebih dari 255 karakter.',
        'id_user.integer' => 'ID pengguna harus berupa angka.',
        'id_user.exists' => 'Pengguna yang dipilih tidak valid.',
        'id_unit_kerja.integer' => 'ID unit kerja harus berupa angka.',
        'id_unit_kerja.exists' => 'Unit kerja yang dipilih tidak valid.',
        'id_mentor.integer' => 'ID mentor harus berupa angka.',
        'id_mentor.exists' => 'Mentor yang dipilih tidak valid.',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->pesertas = Peserta::where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->users = User::all();
        $this->unit_kerjas = UnitKerja::where('deleted_at', null)->get();
        $this->mentors = Mentor::where('deleted_at', null)->get();
    }

    public function store()
    {
        try {
            $this->validate();

            Peserta::create([
                'nama_peserta' => $this->nama_peserta,
                'id_user' => $this->id_user,
                'id_unit_kerja' => $this->id_unit_kerja,
                'id_mentor' => $this->id_mentor,
                'created_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data peserta berhasil disimpan!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_peserta'][0] ?? $e->errors()['id_user'][0] ?? $e->errors()['id_unit_kerja'][0] ?? $e->errors()['id_mentor'][0]
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
                'nama_peserta' => 'required|string|max:255',
                'id_user' => 'nullable|integer|exists:users,id',
                'id_unit_kerja' => 'nullable|integer|exists:tb_unit_kerja,id_unit_kerja',
                'id_mentor' => 'nullable|integer|exists:tb_mentor,id_mentor',
            ]);

            $peserta = Peserta::create([
                'nama_peserta' => $validated['nama_peserta'],
                'id_user' => $validated['id_user'],
                'id_unit_kerja' => $validated['id_unit_kerja'],
                'id_mentor' => $validated['id_mentor'],
                'created_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data peserta berhasil disimpan',
                'errors' => [],
                'data' => $peserta,
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
            $data = Peserta::where('deleted_at', null)->get();
            return response()->json([
                'status' => 200,
                'message' => 'Data peserta berhasil diambil',
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
            $data = Peserta::findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Data peserta berhasil diambil',
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
                'nama_peserta' => 'required|string|max:255',
                'id_user' => 'nullable|integer|exists:users,id',
                'id_unit_kerja' => 'nullable|integer|exists:tb_unit_kerja,id_unit_kerja',
                'id_mentor' => 'nullable|integer|exists:tb_mentor,id_mentor',
            ]);

            Peserta::where('id_peserta', $id)->update([
                'nama_peserta' => $validated['nama_peserta'],
                'id_user' => $validated['id_user'],
                'id_unit_kerja' => $validated['id_unit_kerja'],
                'id_mentor' => $validated['id_mentor'],
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data peserta berhasil diupdate',
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
            Peserta::where('id_peserta', $id)->update(['deleted_at' => now()]);
            return response()->json([
                'status' => 200,
                'message' => 'Data peserta berhasil dihapus',
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
            $peserta = Peserta::findOrFail($id);
            $this->nama_peserta = $peserta->nama_peserta;
            $this->id_user = $peserta->id_user;
            $this->id_unit_kerja = $peserta->id_unit_kerja;
            $this->id_mentor = $peserta->id_mentor;
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

            Peserta::where('id_peserta', $this->edit_id)->update([
                'nama_peserta' => $this->nama_peserta,
                'id_user' => $this->id_user,
                'id_unit_kerja' => $this->id_unit_kerja,
                'id_mentor' => $this->id_mentor,
                'updated_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data peserta berhasil diupdate!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_peserta'][0] ?? $e->errors()['id_user'][0] ?? $e->errors()['id_unit_kerja'][0] ?? $e->errors()['id_mentor'][0]
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
            Peserta::where('id_peserta', $id)->update(['deleted_at' => now()]);
            session()->flash('message', 'Data peserta berhasil dihapus');
            $this->loadData();
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function resetForm()
    {
        $this->nama_peserta = '';
        $this->id_user = null;
        $this->id_unit_kerja = null;
        $this->id_mentor = null;
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
        return view('livewire.peserta')->extends('layout.layouts');
    }
}