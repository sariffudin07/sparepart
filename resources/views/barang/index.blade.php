@extends('layouts')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <button class="btn my-2 btn-primary btn-sm tambah">Tambah</button>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>KODE BARANG</td>
                                    <td>NAMA BARANG</td>
                                    <td>HARGA JUAL</td>
                                    <td>HARGA BELI</td>
                                    <td>SATUAN</td>
                                    <td>KATEGORI</td>
                                    <td>ACTION</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                <tr>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->harga_jual }}</td>
                                    <td>{{ $item->harga_beli }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>
                                        <a href="" class="icon-link edit" data-barang="{{ $item }}">
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
                            {{ $barang->links()}}
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Data Barang</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/barang">
                <input type="hidden" name="id">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" name="kode_barang" id="kode_barang">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual">
                                <div class="form-text text-danger"></div>
                              </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <input type="number" class="form-control" name="harga_beli" id="harga_beli">
                                <div class="form-text text-danger"></div>
                              </div>
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control" name="satuan" id="satuan">
                                <div class="form-text text-danger"></div>
                              </div>
                              <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="kategori" id="kategori">
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
                        url: `/barang/${id}`,
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
                let barang = $(this).data("barang")
                $("[name='id']").val(barang.id)
                $("[name='kode_barang']").val(barang.kode_barang)
                $("[name='nama_barang']").val(barang.nama_barang)
                $("[name='harga_jual']").val(barang.harga_jual)
                $("[name='harga_beli']").val(barang.harga_beli)
                $("[name='satuan']").val(barang.satuan)
                $("[name='kategori']").val(barang.kategori)
                $("#exampleModal").modal("show")
            })
            $(".tambah").click(function(e){
                e.preventDefault()
                let barang = $(this).data("barang")
                $("[name='id']").val("")
                $("[name='kode_barang']").val("")
                $("[name='nama_barang']").val("")
                $("[name='harga_jual']").val("")
                $("[name='harga_beli']").val("")
                $("[name='satuan']").val("")
                $("[name='kategori']").val("")
                $("#exampleModal").modal("show")
            })
        })
        $(".submit").click(function(e) {
            e.preventDefault()
            $.ajax({
                url: '/barang',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}",
                },
                data: {
                    id: $("[name='id']").val(),
                    kode_barang: $("[name='kode_barang']").val(),
                    nama_barang: $("[name='nama_barang']").val(),
                    harga_jual: $("[name='harga_jual']").val(),
                    harga_beli: $("[name='harga_beli']").val(),
                    satuan: $("[name='satuan']").val(),
                    kategori: $("[name='kategori']").val()
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
                        console.log(errors,"test")
                        Object.keys(errors).forEach(key => {
                            $(`[name=${key}]`).siblings(".form-text").text(errors[key][0])
                        });

                    }
                    else {
                        console.log("test", err)

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
