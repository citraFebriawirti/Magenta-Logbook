<div>
    <section class="">
        <section class="section">
            <div class="section-header">
                <h1> Kegiatan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Kegiatan</div>
                </div>
            </div>
        </section>



        <!-- Modal for Add/Edit -->
        <div wire:ignore.self class="modal fade" id="KegiatanModal" tabindex="-1" aria-labelledby="KegiatanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="KegiatanModalLabel">
                            {{ $is_edit_mode ? 'Edit Kegiatan' : 'Tambah Kegiatan' }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="{{ $is_edit_mode ? 'update' : 'store' }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_peserta" class="form-label">ID Peserta</label>
                                        <input type="number" class="form-control" wire:model.defer="id_peserta">
                                    </div>

                                    <div class="mb-3">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" class="form-control"
                                            wire:model.defer="tanggal_mulai_kegiatan">
                                    </div>

                                    <div class="mb-3">
                                        <label>Deskripsi Kegiatan</label>
                                        <textarea class="form-control" wire:model.defer="deskripsi_kegiatan"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label>Keterangan</label>
                                        <textarea class="form-control"
                                            wire:model.defer="keterangan_kegiatan"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Tanggal Selesai</label>
                                        <input type="date" class="form-control"
                                            wire:model.defer="tanggal_selesai_kegiatan">
                                    </div>

                                    <div class="mb-3">
                                        <label>Progres (%)</label>
                                        <input type="number" class="form-control" wire:model.defer="progres_kegiatan">
                                    </div>

                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select class="form-control" wire:model.defer="status_kegiatan">
                                            <option value="draft">Draft</option>
                                            <option value="submitted">Submitted</option>
                                            <option value="validated">Validated</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Catatan Pembimbing</label>
                                        <textarea class="form-control " wire:model.defer="catatan_pembimbing"></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit"
                                class="btn btn-primary">{{ $is_edit_mode ? 'Update' : 'Simpan' }}</button>
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
                            <h4>Daftar Kegiatan</h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#KegiatanModal" wire:click="resetForm">
                                Tambah Kegiatan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="table-kegiatan">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th>Peserta</th>
                                <th>Deskripsi Kegiatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Progres (%)</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kegiatans as $index => $kegiatan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $kegiatan->peserta->nama_peserta ?? '-' }}</td>
                                <td>{{ $kegiatan->deskripsi_kegiatan }}</td>
                                <td>{{ $kegiatan->tanggal_mulai_kegiatan }}</td>
                                <td>{{ $kegiatan->tanggal_selesai_kegiatan }}</td>
                                <td>{{ $kegiatan->progres_kegiatan ?? 0 }}%</td>
                                <td>
                                    @php
                                    $badgeClass = [
                                    'draft' => 'secondary',
                                    'submitted' => 'primary',
                                    'validated' => 'success',
                                    'rejected' => 'danger',
                                    ][$kegiatan->status_kegiatan] ?? 'secondary';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badgeClass }}">{{ ucfirst($kegiatan->status_kegiatan) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning mr-2"
                                            wire:click="edit({{ $kegiatan->id_kegiatan }})" type="button"
                                            data-toggle="modal" data-target="#KegiatanModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $kegiatan->id_kegiatan }})" type="button">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data kegiatan.</td>
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
                $('#KegiatanModal').modal('hide');
                console.log('closeModal event received'); // Debugging
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
