@extends('layouts.dashboard')
@section('content')
<section class="container">
    <div class="row" style="margin-top: 45px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DCC-UHD Model</div>
                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="bill-table">
                        <thead>
                            <th>#</th>
                            <th>Months</th>
                            <th>Billing Invoice</th>
                            <th>PO No.</th>
                            <th>Product Model</th>
                            <th>PO No Qty</th>
                            <th>Balance Qty</th>
                            <th>Billed Qty</th>
                           

                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="6" style="text-align:right">Total Billed QTY:</th>
                                <th></th>
                                <th></th>
                             
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
</section>
@include('admins.transfer-inventory')

@include('partials.footer')
<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {

        //show list Billed
        $('#bill-table').DataTable({
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            info: true,
            bAutoWidth: false,
            ajax: "{{ route('dcc.uhd.list') }}",
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
                    data: 'productName',
                    name: 'productName'
                },
                {
                    data: 'poQty',
                    name: 'poQty'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },
                {
                    data: 'billQty',
                    name: 'billQty'
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
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                total = api
                    .column(7, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                

                // Update footer
                $(api.column(6).footer()).html(
                    pageTotal
                );

                $(api.column(7).footer()).html(
                    total + " Balance QTY"
                );
              


            }
        });
        $(document).on('click', '#transfer', function() {
            var transfer_id = $(this).data('id');
            $('#tansferInventory').modal('toggle');
            $('#tansferID').val(transfer_id);
        })
        $('#transferInventoryForm').on('submit', function(e) {
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
                    } else if (data.code == 2) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss..',
                            text: data.msg,
                            timer: 3500
                        });
                    } else {
                        $(form)[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully',
                            text: data.msg,
                            timer: 3500
                        });

                        $('#tansferInventory').modal('hide');
                        $('#bill-table').DataTable().ajax.reload();
                    }
                }

            })
        })
       

    });
</script>
@endsection