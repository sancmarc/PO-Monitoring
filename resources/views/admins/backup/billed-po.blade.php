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
                            <th>Billing Months</th>
                            <th>Billing Invoice</th>
                            <th>PO No.</th>
                            <th>PO No Qty</th>
                            <th>Billed Qty</th>
                            <th>Balance Qty</th>
                            <th>Cancelled Billed Qty</th>
                            <th>Cancelled Date</th>
                            <th>Actions</th>
                            <!-- <th>Delivery Date</th>
                            <th>Out Delivered</th> -->

                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Total Billed QTY:</th>
                                <th></th>
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
                                <input type="text" class="form-control" name="billInvoice" id="billInvoice">
                                <span class="text-danger error-text billInvoice_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="po_no">PO No.</label>
                                <select type="text" class="form-control" name="po_no" id="po_no">
                                    <option selected>---</option>
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
        <!-- update modal -->
        <!-- Modal -->
        <div class="modal fade" id="updateBillingModal" tabindex="-1" aria-labelledby="updateBillingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateBillingModalLabel">Update FORM Billed</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('update.bill')}}" method="post" id="Updatebilling">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" readonly class="form-control" name="billId" id="billId">
                            <div class="form-group">
                                <label for="months">Months</label>
                                <input type="date" class="form-control" name="months" id="months">
                                <span class="text-danger error-text months_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="billInovoice">Billing Invoice</label>
                                <input type="text" class="form-control" name="billInvoice" id="billInvoice">
                                <span class="text-danger error-text billInvoice_error"></span>
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
        <!-- modal cancelled -->
        <div class="modal fade" id="cancelBillingModal" tabindex="-1" aria-labelledby="cancelBillingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelBillingModalLabel">Cancelled Billing FORM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('create.cancel')}}" method="post" id="cancelBilling">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" readonly class="form-control" name="billed_id" id="billed_id">
                            <div class="form-group">
                                <label for="cancelled_date">DATE</label>
                                <input type="date" class="form-control" name="cancelled_date" id="cancelled_date">
                                <span class="text-danger error-text cancelled_date_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="cancelled_qty">Cancel Quantity</label>
                                <input type="number" class="form-control" name="cancelled_qty" id="cancelled_qty">
                                <span class="text-danger error-text cancelled_qty_error"></span>
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
                [1, 'desc']
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            info: true,
            bAutoWidth: false,
            ajax: "{{ route('list.bill') }}",
            aLengthMenu: [
                [15, 25, 50, 100, -1],
                [15, 25, 50, 100, "ALL"]
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
                {
                    data: 'cancelled_qty',
                    name: 'cancelled_qty'
                },
                {
                    data: 'cancelled_date',
                    name: 'cancelled_date'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
                // {
                //     data: 'delivery',
                //     name: 'delivery'
                // },
                // {
                //     data: 'out',
                //     name: 'out'
                // },
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
                // total cancelled billed
                cancelledTotal = api
                .column (7,{
                    page:'current'
                })
                .data()
                .reduce(function(a,b){
                    return intVal(a) + intVal(b);
                }, 0)

                // Update footer
                $(api.column(5).footer()).html(
                    pageTotal
                );

                $(api.column(6).footer()).html(
                    total + " Balance QTY"
                );
                $(api.column(7).footer()).html(
                    cancelledTotal + " Cancelled QTY"
                );



            }
        });
        $(document).on('click', '#editBtn', function() {
            var billId = $(this).data('id');
            $('#updateBillingModal').find('form')[0].reset();
            var url = "{{route('edit.bill')}}";
            $.post(url, {
                billId: billId
            }, function(data) {
                $('#updateBillingModal').find('#billId').val(data.details.id);
                $('#updateBillingModal').find('#months').val(data.details.billing_months);
                $('#updateBillingModal').find('#billInvoice').val(data.details.billing_invoice);
                $('#updateBillingModal').modal('show');
            })
        })
        $('#Updatebilling').on('submit', function(e) {
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
        $(document).on('click', '#cancelBtn', function() {
            var cancelID = $(this).data('id');
            $('#billed_id').val(cancelID);
            $('#cancelBillingModal').modal('show');
        })
        $('#cancelBilling').on('submit', function(e) {
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

                        if (data.code == 0) {
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
                            $('#bill-table').DataTable().draw();
                        }

                    }
                }
            });
        })

    });
</script>
@endsection