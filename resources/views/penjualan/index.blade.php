@extends('layouts')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <button class="btn my-2 btn-primary btn-sm tambah">Tambah</button>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td>TANGGAL FAKTUR</td>
                                    <td>NOMOR FAKTUR</td>
                                    <td>NAMA KONSUMEN</td>
                                    <td>KODE BARANG</td>
                                    <td>JUMLAH</td>
                                    <td>HARGA SATUAN</td>
                                    <td>HARGA TOTAL</td>
                                    <td>ACTION</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan as $item)
                                <tr>
                                    <td>{{ $item->tgl_faktur }}</td>
                                    <td>{{ $item->no_faktur }}</td>
                                    <td>{{ $item->nama_konsumen }}</td>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->harga_satuan }}</td>
                                    <td>{{ $item->harga_total }}</td>
                                    <td>
                                        <a href="" class="icon-link edit" data-penjualan="{{ $item }}">
                                            <span class="material-symbols-outlined text-primary" >
                                                edit
                                            </span>
                                        </a>
                                        <a href="" class="icon-link delete" data-id="{{ $item->id }}">
                                            <span class="material-symbols-outlined text-danger" >
                                                delete
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="m-auto">
                            {{ $penjualan->links()}}
                        </div>
                </div>
            </div>
        </div>
    </div>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Data Penjualan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/barang">
                <input type="hidden" name="id">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="tgl_faktur" class="form-label">Tanggal Faktur</label>
                                <input type="date" class="form-control" name="tgl_faktur" id="tgl_faktur">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="no_faktur" class="form-label">Nomor Faktur</label>
                                <input type="text" class="form-control" name="no_faktur" id="no_faktur">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="nama_konsumen" class="form-label">Nama Konsumen</label>
                                <input type="text" class="form-control" name="nama_konsumen" id="nama_konsumen">
                                <div class="form-text text-danger"></div>
                              </div>
                        </div>
                        <div class="col">
                            <input type="hidden" class="form-control" name="kode_barang" id="kode_barang">
                            <input type="hidden" class="form-control" name="barang_id" id="barang_id">
                            <div class="mb-3">
                                <label for="state" class="form-label">Kode Barang</label>
                                <select class="get-data-barang col" name="state">
                                    <option value="" class="default-option"></option>
                                    @foreach ($barang as $b)
                                        <option value="{{ $b }}" data-selected="{{ $b }}">{{ $b->kode_barang . " - " . $b->nama_barang}}</option>
                                    @endforeach
                                  </select>
                                <div class="form-text text-danger"></div>
                              </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah"  value="1" min="1" id="jumlah">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <input type="number" class="form-control" name="harga_satuan" id="harga_satuan" disabled>
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="harga_total" class="form-label">Harga Total</label>
                                <input type="number" class="form-control" name="harga_total" id="harga_total" disabled>
                                <div class="form-text text-danger"></div>
                              </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary submit">Submit</button>
              </form>
        </div>
      </div>
    </div>
  </div>
    <script>
        $(document).ready(function(){
            $('.get-data-barang').select2({
                dropdownParent: $('#exampleModal'),
                placeholder: "Pilih barang",
                width: "100%"
            });
            $("[name=state]").change(function(){
                data = JSON.parse(this.value)
                let harga_jual = data.harga_jual
                let jumlah = $("[name='jumlah']").val()
                let harga_total = harga_jual * jumlah
                
                $("[name='kode_barang']").val(data.kode_barang)
                $("[name='barang_id']").val(data.id)

                $("[name='harga_satuan']").val(harga_jual)
                $("[name='harga_total']").val(harga_total)
            })
            $("[name='jumlah']").change(function(){
                let harga_jual =  $("[name='harga_satuan']").val()
                let harga_total = harga_jual * this.value
                $("[name='harga_total']").val(harga_total)
            })
            $(".delete").click(function(e){
                e.preventDefault()
                id = $(this).data("id")
                Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/penjualan/${id}`,
                        type:'DELETE',
                        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        success: function(result){
                            Swal.fire({
                            title: "Deleted!",
                            text: "Your data has been deleted.",
                            showConfirmButton: false,
                            icon: "success"
                            })
                            location.reload()
                        },
                        fail: function() {
                            Swal.fire({
                            title: "Failed!",
                            text: "Fail deleted data.",
                            icon: "error"
                            });
                        }
                    })
                }
                });
            })

            $(".edit").click(function(e){
                e.preventDefault()
                let penjualan = $(this).data("penjualan")
                $("[name='id']").val(penjualan.id)
                $("[name='barang_id']").val(penjualan.barang.id)
                $("[name='tgl_faktur']").val(penjualan.tgl_faktur)
                $("[name='no_faktur']").val(penjualan.no_faktur)
                $("[name='nama_konsumen']").val(penjualan.nama_konsumen)
                $("[name='kode_barang']").val(penjualan.kode_barang)
                $("[name='jumlah']").val(penjualan.jumlah)
                $("[name='harga_satuan']").val(penjualan.harga_satuan)
                $("[name='harga_total']").val(penjualan.harga_total)
                $("#exampleModal").modal("show")
                $(`select option:contains(${penjualan.barang.kode_barang} - ${penjualan.barang.nama_barang})`).prop('selected',true);
            })
            $(".tambah").click(function(e){
                e.preventDefault()
                let barang = $(this).data("barang")
                $("[name='id']").val("")
                $("[name='tgl_faktur']").val("")
                $("[name='no_faktur']").val("")
                $("[name='nama_konsumen']").val("")
                $("[name='kode_barang']").val("")
                $("[name='jumlah']").val(1)
                $("[name='harga_satuan']").val("")
                $("[name='harga_total']").val("")
                $("#exampleModal").modal("show")
            })
        })
        $(".submit").click(function(e) {
            e.preventDefault()
            $.ajax({
                url: '/penjualan',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}",
                },
                data: {
                    id: $("[name='id']").val(),
                    barang_id: $("[name='barang_id']").val(),
                    tgl_faktur: $("[name='tgl_faktur']").val(),
                    no_faktur: $("[name='no_faktur']").val(),
                    nama_konsumen: $("[name='nama_konsumen']").val(),
                    kode_barang: $("[name='kode_barang']").val(),
                    jumlah: $("[name='jumlah']").val(),
                    harga_satuan: $("[name='harga_satuan']").val(),
                    harga_total: $("[name='harga_total']").val()
                },
                success: function(result){
                            Swal.fire({
                            title: "Success!",
                            text: "Your data has been updated.",
                            showConfirmButton: false,
                            icon: "success"
                            })
                            location.reload()
                        },
                error: function(err) {
                    if(err.status == 422){
                        let errors = err.responseJSON.errors
                        Object.keys(errors).forEach(key => {
                            $(`[name=${key}]`).siblings(".form-text").text(errors[key][0])
                        });

                    }
                },
                fail: function(result) {
                    Swal.fire({
                    title: "Failed!",
                    text: "Fail deleted data.",
                    icon: "error"
                    });
                }
            })
        })
    </script>
@endsection
