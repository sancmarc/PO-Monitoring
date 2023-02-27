@extends('layouts.dashboard')
@section('content')
<section class="container">
    <!-- Button trigger modal -->



    <div class="row" style="margin-top: 45px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Billing Monitoring <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addBilling">
                        &plus; ADD BILLED
                    </button></div>
                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="bill-table">
                        <thead>
                            <th>#</th>
                            <th>Months</th>
                            <th>Billing Invoice</th>
                            <th>PO No.</th>
                            <th>PO No Qty</th>
                            <th>Billed Qty</th>
                            <th>Balance Qty</th>
                            <!-- <th>Actions <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button></th> -->
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Total Billed QTY:</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addBilling" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">FORM Billed</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('submit.bill') }}" method="post" id="add-billing">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="months">Months</label>
                                <input type="date" class="form-control" name="months" id="months">
                                <span class="text-danger error-text months_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="billInovoice">Billing Invoice</label>
                                <input type="text" class="form-control" name="billInovoice" id="billInovoice">
                                <span class="text-danger error-text billInovoice_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="po_no">PO No.</label>
                                <select type="text" class="form-control" name="po_no" id="po_no">
                                    <option>---</option>
                                    @foreach($pono as $po)
                                    @if($po->balancepo > 0){
                                    <option value="{{$po->pid}}">{{$po->pono." Bal ". $po->balancepo." Model ".$po->pn}}</option>
                                    }
                                    @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error-text po_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="billQty">Billed Qty</label>
                                <input type="text" class="form-control" name="billQty" id="billQty">
                                <span class="text-danger error-text billQty_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add Billing Monitoring</div>
                <div class="card-body">
                    <form action="{{ route('submit.bill') }}" method="post" id="add-billing">
                        @csrf
                        <div class="form-group">
                            <label for="months">Months</label>
                            <input type="date" class="form-control" name="months" id="months">
                            <span class="text-danger error-text months_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="billInovoice">Billing Invoice</label>
                            <input type="text" class="form-control" name="billInovoice" id="billInovoice">
                            <span class="text-danger error-text billInovoice_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="po_no">PO No.</label>
                            <select type="text" class="form-control" name="po_no" id="po_no">
                                <option>---</option>
                                @foreach($pono as $po)
                                @if($po->balancepo > 0){
                                <option value="{{$po->pid}}">{{$po->pono." Balance ". $po->balancepo." Model ".$po->pn}}</option>
                                }
                                @endif
                                @endforeach
                            </select>
                            <span class="text-danger error-text po_no_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="billQty">Billed Qty</label>
                            <input type="text" class="form-control" name="billQty" id="billQty">
                            <span class="text-danger error-text billQty_error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
</section>


@include('partials.footer')
<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        // add invoice billing
        $('#add-billing').on('submit', function(e) {
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
                    $(form).find('span.error.text').text('');
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        // $('#bill-table').DataTable().draw();

                        if (data.code == 0) {
                            Swal.fire({

                                icon: 'error',
                                title: 'Oops...',
                                text: data.msg,
                                timer: 2500
                            })
                        } else if (data.code == 2) {
                            //toastr.error(data.msg);
                            Swal.fire({

                                icon: 'error',
                                title: 'Oops...',
                                text: data.msg,
                                timer: 2500
                            })
                        } else {
                            $(form)[0].reset();

                            Swal.fire({

                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 2500
                            })
                            setInterval(function() {
                                location.reload();
                            }, 3000);
                        }

                    }
                }
            });
        });
        //show list Billed
        $('#bill-table').DataTable({
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            info: true,
            ajax: "{{ route('list.bill') }}",
            aLengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "ALL"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'billMonths',
                    name: 'billMonths'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'poNo',
                    name: 'poNo'
                },
                {
                    data: 'poQty',
                    name: 'poQty'
                },
                {
                    data: 'billQty',
                    name: 'billQty'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },
            ],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                // total = api
                //     .column( 5 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );

                // Total billed qty
                pageTotal = api
                    .column(5, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                total = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(5).footer()).html(
                    pageTotal
                );

                $(api.column(6).footer()).html(
                    total + " Balance QTY"
                );



            }
        });

    });
</script>
@endsection