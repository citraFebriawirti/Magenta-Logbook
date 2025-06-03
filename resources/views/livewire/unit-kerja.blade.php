
<div>
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">{{ $editMode ? 'Edit' : 'Tambah' }} Unit Kerja</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                <div class="mb-3">
                    <label for="nama_unit_kerja" class="form-label">Nama Unit Kerja</label>
                    <input type="text" 
                           class="form-control @error('nama_unit_kerja') is-invalid @enderror" 
                           wire:model.defer="nama_unit_kerja"
                           placeholder="Masukkan nama unit kerja">
                    @error('nama_unit_kerja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    @if($editMode)
                        <button type="button" 
                                class="btn btn-secondary" 
                                wire:click="$set('editMode', false)">
                            Batal
                        </button>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        {{ $editMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Data Unit Kerja</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Unit Kerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unitKerjas as $index => $unitKerja)
                            <tr>
                                <td>{{ $unitKerjas->firstItem() + $index }}</td>
                                <td>{{ $unitKerja->nama_unit_kerja }}</td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-warning btn-sm"
                                            wire:click="edit('{{ $unitKerja->id }}')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm"
                                            wire:click="$emit('confirmDelete', '{{ $unitKerja->id }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end">
                {{ $unitKerjas->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('confirmDelete', unitKerjaId => {
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.delete(unitKerjaId)
                    }
                })
            });

            window.addEventListener('swal:success', event => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: event.detail.message,
                    timer: 3000,
                    showConfirmButton: false
                });
            });

            window.addEventListener('swal:error', event => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: event.detail.message
                });
            });
        });
    </script>
    @endpush
</div>