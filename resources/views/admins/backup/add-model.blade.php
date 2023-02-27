@extends('layouts.dashboard')

@section('content')
<section class="container">
    <div class="row" style="margin-top: 45px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product Model</div>
                <div class="card-body">
                    <table class="table table-hover table-condensed dt-responsive nowrap" id="modelTable">
                        <thead>
                            <th>#</th>
                            <th>Model</th>
                            <th>Actions</th>
                        </thead>


                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add new Model</div>
                <div class="card-body">
                    <form action="{{ route('create.model') }}" method="post" id="addModel">
                        @csrf
                        <div class="form-group">
                            <label for="received_date">Model</label>
                            <input type="text" class="form-control" name="modelProduct" id="modelProduct">
                            <span class="text-danger error-text modelProduct_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit-->
<div class="modal fade editModel" id="editModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard=" false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Model</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= route('update.model') ?>" method="post" id="update-model-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="mod_id" id="mod_id">
                    <div class="form-group">
                        <label for="modelProduct">Model</label>
                        <input type="text" class="form-control" name="modelProduct" id="modelProduct">
                        <span class="text-danger error-text modelProduct_error"></span>
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
        $('#addModel').on('submit', function(e) {
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
                        $('#modelTable').DataTable().ajax.reload();
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
        $('#modelTable').DataTable({
            processing: true,
            serverside: true,
            responsive: true,
            info: true,
            bAutoWidth:false,
            ajax: "{{ route('list.model') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'modelProduct',
                    name: 'modelProduct'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        // get model for edit
        $(document).on('click', '#editBtn', function() {
            var model_id = $(this).data('id');
            $('#editModel').find('form')[0].reset();
            $('#editModel').find('span.error-text').text('');
            $.post('<?= route("edit.model.product") ?>', {
                model_id: model_id
            }, function(data) {
                $('#editModel').find('#mod_id').val(data.details.id);
                $('#editModel').find('#modelProduct').val(data.details.modelProduct);
                $('#editModel').modal('show');
            },'json');
        });
        // submit edit model

        $('#update-model-form').on('submit', function(e) {
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
                        $('#editModel').modal('hide');
                        $('#editModel').find('form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully!',
                            text: data.msg,
                            timer: 2500
                        })
                        $('#modelTable').DataTable().ajax.reload();
                    }
                }
            });
        });
        $(document).on('click', '#deleteBtn', function(){
            var model_id = $(this).data('id');
            var url = '<?= route("delete.model") ?>';
      
            Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    html: 'You want to <b>Delete</b> this Model?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then(function(result){
                    if(result.value){
             
                        $.post(url,{model_id:model_id}, function(data){
                            
                            if(data.code ==1){
                                Swal.fire({
                                      icon: 'success',
                                      title: 'Successfully',
                                      text: data.msg,
                                      timer: 3500
                                    });
                                    $('#modelTable').DataTable().ajax.reload();
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