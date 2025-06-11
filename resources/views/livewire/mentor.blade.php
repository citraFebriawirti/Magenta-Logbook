<div>
    <section>
        <section class="section">
            <div class="section-header">
                <h1>Data Mentor</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Mentor</div>
                </div>
            </div>
        </section>

        <!-- Modal for Add/Edit -->
        <div wire:ignore.self class="modal fade" id="mentorModal" tabindex="-1" aria-labelledby="mentorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mentorModalLabel">
                            {{ $is_edit_mode ? 'Edit Mentor' : 'Tambah Mentor' }}
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="{{ $is_edit_mode ? 'update' : 'store' }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_mentor" class="form-label">Nama Mentor</label>
                                <input type="text" class="form-control @error('nama_mentor') is-invalid @enderror" id="nama_mentor" wire:model.defer="nama_mentor">
                                @error('nama_mentor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jabatan_mentor" class="form-label">Jabatan Mentor</label>
                                <input type="text" class="form-control @error('jabatan_mentor') is-invalid @enderror" id="jabatan_mentor" wire:model.defer="jabatan_mentor">
                                @error('jabatan_mentor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="id_users" class="form-label">Pengguna (Opsional)</label>
                                <select class="form-control @error('id_users') is-invalid @enderror" id="id_users" wire:model.defer="id_users">
                                    <option value="">Pilih Pengguna</option>
                                    @foreach (\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_users')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label for="id_unit_kerja" class="form-label">Unit Kerja (Opsional)</label>
                                <select class="form-control @error('id_unit_kerja') is-invalid @enderror" id="id_unit_kerja" wire:model.defer="id_unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach (\App\Models\UnitKerja::all() as $unit)
                                        <option value="{{ $unit->id_unit_kerja }}">{{ $unit->nama_unit_kerja }}</option>
                                    @endforeach
                                </select>
                                @error('id_unit_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">{{ $is_edit_mode ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table section -->
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Daftar Mentor</h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mentorModal" wire:click="resetForm">
                                Tambah Mentor
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="table-2">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%">No</th>
                                <th>Nama Mentor</th>
                                <th>Jabatan Mentor</th>
                                <th>Unit Kerja</th>
                                {{-- <th>Pengguna</th> --}}
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mentors as $index => $mentor)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $mentor->nama_mentor }}</td>
                                    <td>{{ $mentor->jabatan_mentor }}</td>
                                    <td>{{ $mentor->unitKerja ? $mentor->unitKerja->nama_unit_kerja : '-' }}</td>
                                    {{-- <td>{{ $mentor->user ? $mentor->user->name : '-' }}</td> --}}
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-warning mr-2" wire:click="edit({{ $mentor->id_mentor }})" type="button" data-toggle="modal" data-target="#mentorModal">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $mentor->id_mentor }})" type="button">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Handle modal
        document.addEventListener('livewire:init', () => {
            window.addEventListener('closeModal', event => {
                $('#mentorModal').modal('hide');
                console.log('closeModal event received');
            });
        });

        // Handle delete confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.delete(id)
                }
            });
        }

        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            Livewire.on('showAlert', (event) => {
                Swal.fire({
                    icon: event[0].type,
                    title: event[0].type === 'success' ? 'Berhasil!' : 'Error!',
                    text: event[0].message,
                    timer: event[0].type === 'success' ? 1500 : undefined,
                    showConfirmButton: event[0].type === 'error',
                    position: 'top-end',
                    toast: event[0].type === 'success',
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            });
        });
    </script>
</div>