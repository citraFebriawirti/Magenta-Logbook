<?php

namespace App\Livewire;

use App\Models\UnitKerja as UnitKerjaModel;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class UnitKerja extends Component
{

    use WithPagination;
    public $nama_unit_kerja = '';
    public $unit_kerjas;
    public $edit_id = null;
    public $is_edit_mode = false;

    protected $rules = [
        'nama_unit_kerja' => 'required|string|max:255',
    ];

    protected $messages = [
        'nama_unit_kerja.required' => 'Nama unit kerja wajib diisi.',
        'nama_unit_kerja.string' => 'Nama unit kerja harus berupa teks.',
        'nama_unit_kerja.max' => 'Nama unit kerja tidak boleh lebih dari 255 karakter.',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->unit_kerjas = UnitKerjaModel::where('deleted_at', null)
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();
    }

    public function store()
    {
        try {
            $this->validate();

            UnitKerjaModel::create([
                'nama_unit_kerja' => $this->nama_unit_kerja,
                'created_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data berhasil disimpan!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_unit_kerja'][0]
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
                'nama_unit_kerja' => 'required|string|max:255',
            ]);

            $unit_kerja = UnitKerjaModel::create([
                'nama_unit_kerja' => $validated['nama_unit_kerja'],
                'created_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan',
                'errors' => [],
                'data' => $unit_kerja,
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
            $data = UnitKerjaModel::where('deleted_at', null)->get();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diambil',
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
            $data = UnitKerjaModel::findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diambil',
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
                'nama_unit_kerja' => 'required|string|max:255',
            ]);

            UnitKerjaModel::where('id_unit_kerja', $id)->update([
                'nama_unit_kerja' => $validated['nama_unit_kerja'],
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diupdate',
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
            UnitKerjaModel::where('id_unit_kerja', $id)->update(['deleted_at' => now()]);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus',
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
            $unit_kerja = UnitKerjaModel::findOrFail($id);
            $this->nama_unit_kerja = $unit_kerja->nama_unit_kerja;
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

            UnitKerjaModel::where('id_unit_kerja', $this->edit_id)->update([
                'nama_unit_kerja' => $this->nama_unit_kerja,
                'updated_at' => now(),
            ]);

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Data berhasil diupdate!'
            ]);
            $this->resetForm();
            $this->loadData();
            $this->dispatch('closeModal');
        } catch (ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $e->errors()['nama_unit_kerja'][0]
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
            UnitKerjaModel::where('id_unit_kerja', $id)->update(['deleted_at' => now()]);
            session()->flash('message', 'Data berhasil dihapus');
            $this->loadData();
        } catch (\Throwable $th) {
            session()->flash('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function resetForm()
    {
        $this->nama_unit_kerja = '';
        $this->edit_id = null;
        $this->is_edit_mode = false;
        // $this->resetErrorBag();
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
        return view('livewire.unit-kerja')->extends('layout.layouts');
    }
}
