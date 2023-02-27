@extends('layouts.dashboard')

@section('content')
<section class="container">
    <div class="row" style="margin-top: 45px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product</div>
                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="productTable">
                        <thead>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Actions </th>
                        </thead>


                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add new Product</div>
                <div class="card-body">
                    <form action="{{route('create.product')}}" method="post" id="addProduct">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name">
                            <span class="text-danger error-text product_name_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal Edit-->
<div class="modal fade editProduct" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard=" false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= route('update.product') ?>" method="post" id="update-product-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="prod_id" id="prod_id">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name">
                        <span class="text-danger error-text product_name_error"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials.footer')
<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        // add

        $('#addProduct').on('submit', function(e) {
            e.preventDefault();
            var form = this;

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {

                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#productTable').DataTable().ajax.reload();
                        $(form)[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully!',
                            text: data.msg,
                            timer: 2500
                        })
                    }
                }
            });
        });
        // fetch
        $('#productTable').DataTable({
            processing: true,
            serverside: true,
            responsive: true,
            info: true,
            bAutoWidth:false,
            ajax: "{{ route('list.product') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        // get edit click

        $(document).on('click', '#editBtn', function() {
            var product_id = $(this).data('id');
            $('#editProduct').find('form')[0].reset();
            $('#editProduct').find('span.error-text').text('');
            $.post('<?= route("edit.product") ?>', {
                product_id: product_id
            }, function(data) {
                $('#editProduct').find('#prod_id').val(data.details.id);
                $('#editProduct').find('#product_name').val(data.details.product_name);
                $('#editProduct').modal('show');
            })
        });
        // update product submit
        $('#update-product-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {

                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#editProduct').modal('hide');
                        $('#editProduct').find('form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully!',
                            text: data.msg,
                            timer: 2500
                        })
                        $('#productTable').DataTable().ajax.reload();
                    }
                }
            });
        });
        // delete
        $(document).on('click', '#deleteBtn', function(){
            var product_id = $(this).data('id');
            var url = '<?= route("delete.product") ?>';
      
            Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    html: 'You want to <b>Delete</b> this Product?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then(function(result){
                    if(result.value){
             
                        $.post(url,{product_id:product_id}, function(data){
                            
                            if(data.code ==1){
                                Swal.fire({
                                      icon: 'success',
                                      title: 'Successfully',
                                      text: data.msg,
                                      timer: 3500
                                    });
                                    $('#productTable').DataTable().draw();
                            }else{
                                // toastr.error(data.msg);
                                Swal.fire({
                                      icon: 'error',
                                      title: 'Oopss..',
                                      text: data.msg,
                                      timer: 3500
                                    });
                            }
                        },'json')
                    }
                });

        })

    });
</script>
@endsection