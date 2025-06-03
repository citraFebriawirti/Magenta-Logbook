<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UnitKerja as UnitKerjaModel;

class UnitKerja extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // Tambahkan ini untuk styling bootstrap

    public $nama_unit_kerja = '';
    public $unit_kerja_id;
    public $editMode = false;

    protected $rules = [
        'nama_unit_kerja' => 'required|string|max:255'
    ];

    protected $messages = [
        'nama_unit_kerja.required' => 'Nama unit kerja harus diisi',
        'nama_unit_kerja.max' => 'Nama unit kerja maksimal 255 karakter'
    ];

    public function store()
    {
        $this->validate();

        try {
            UnitKerjaModel::create([
                'nama_unit_kerja' => $this->nama_unit_kerja
            ]);

            $this->reset('nama_unit_kerja');
            $this->dispatch('swal:success', [
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $unitKerja = UnitKerjaModel::findOrFail($id);
            $this->unit_kerja_id = $unitKerja->id;
            $this->nama_unit_kerja = $unitKerja->nama_unit_kerja;
            $this->editMode = true;
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update()
    {
        $this->validate();

        try {
            UnitKerjaModel::where('id', $this->unit_kerja_id)
                ->update([
                    'nama_unit_kerja' => $this->nama_unit_kerja
                ]);

            $this->reset(['nama_unit_kerja', 'unit_kerja_id', 'editMode']);
            $this->dispatch('swal:success', [
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            UnitKerjaModel::findOrFail($id)->delete();
            $this->dispatch('swal:success', [
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $unitKerjas = UnitKerjaModel::paginate(2);

        return view('livewire.unit-kerja', [
            'unitKerjas' => $unitKerjas
        ])->extends('layout.layouts');
    }
}