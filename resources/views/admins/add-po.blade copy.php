@extends('layouts.dashboard')

@section('content')
<section class="container">
    <!-- Button trigger modal -->



    <div class="row" style="margin-top: 45px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">PO Monitoring <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        &plus; Add PO
                    </button></div>
                <div class="card-body">
                    <table class="table table-hover table-condensed dt-responsive nowrap" id="PO-table">
                        <thead>
                            <th>#</th>
                            <th>PO DATE Received</th>
                            <th>Model</th>
                            <th>Product</th>
                            <th>PO No.</th>
                            <th>Unit Price(USD)</th>
                            <th>QTY</th>
                            <th>Balance PO</th>
                            <!-- <th>Actions <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button></th> -->
                        </thead>

                        <tfoot>
                            <tr>
                                <th colspan="6" style="text-align:right">Accum. Output:</th>
                                <th></th>

                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">FORM PO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('submit.add') }}" method="post" id="add-po-biph">
                        <div class="modal-body">

                            @csrf
                            <div class="form-group">
                                <label for="received_date">PO Date Received</label>
                                <input type="date" class="form-control" name="received_date" id="received_date">
                                <span class="text-danger error-text received_date_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="model">Model</label>
                                <select type="text" class="form-control" name="model" id="model">
                                    <option>---</option>
                                    @foreach($modelProduct as $model)
                                    <option value="{{$model->id}}">{{$model->modelProduct}}</option>
                                    }
                                    @endforeach
                                </select>
                                <span class="text-danger error-text model_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="p_n">Product</label>
                                <select type="text" class="form-control" name="p_n" id="p_n">
                                    <option>---</option>
                                    @foreach($product_name as $product)
                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
                                    }
                                    @endforeach
                                </select>
                                <span class="text-danger error-text p_n_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="po_no">PO No.</label>
                                <input type="text" class="form-control" name="po_no" id="po_no">
                                <span class="text-danger error-text po_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="unit_price">Unit Price (USD)</label>
                                <input type="text" class="form-control" name="unit_price" id="unit_price">
                                <span class="text-danger error-text unit_price_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="po_qty">PO Qty.(Details)</label>
                                <!-- <textarea name="po_qty" class="form-control" id="po_qty" cols="30" rows="10"></textarea>. -->
                                <input type="text" class="form-control" name="po_qty" id="po_qty">
                                <span class="text-danger error-text po_qty_error"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-3">
            <div class="card">
                <div class="card-header">Add new PO Monitoring</div>
                <div class="card-body">
                    <form action="{{ route('submit.add') }}" method="post" id="add-po-biph">
                        @csrf
                        <div class="form-group">
                            <label for="received_date">PO Date Received</label>
                            <input type="date" class="form-control" name="received_date" id="received_date">
                            <span class="text-danger error-text received_date_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <select type="text" class="form-control" name="model" id="model">
                                <option>---</option>
                                @foreach($modelProduct as $model)
                                <option value="{{$model->id}}">{{$model->modelProduct}}</option>
                                }
                                @endforeach
                            </select>
                            <span class="text-danger error-text model_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="p_n">Product</label>
                            <select type="text" class="form-control" name="p_n" id="p_n">
                                <option>---</option>
                                @foreach($product_name as $product)
                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                }
                                @endforeach
                            </select>
                            <span class="text-danger error-text p_n_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="po_no">PO No.</label>
                            <input type="text" class="form-control" name="po_no" id="po_no">
                            <span class="text-danger error-text po_no_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="unit_price">Unit Price (USD)</label>
                            <input type="text" class="form-control" name="unit_price" id="unit_price">
                            <span class="text-danger error-text unit_price_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="po_qty">PO Qty.(Details)</label>
                            <!-- <textarea name="po_qty" class="form-control" id="po_qty" cols="30" rows="10"></textarea>. -->
                            <input type="text" class="form-control" name="po_qty" id="po_qty">
                            <span class="text-danger error-text po_qty_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
    <!-- cancel balance po -->
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

        //ADD PO
        $('#add-po-biph').on('submit', function(e) {
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
                        $('#PO-table').DataTable().draw();
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

        $('#PO-table').DataTable({
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            info: true,
            ajax: "{{ route('get.po.list') }}",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "ALL"]
            ],
            columns: [
                // {data:'id', name:'id'},
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'receiveddate',
                    name: 'receiveddate'
                },
                {
                    data: 'modelProduct',
                    name: 'modelProduct'
                },
                {
                    data: 'pn',
                    name: 'pn'
                },
                {
                    data: 'pono',
                    name: 'pono'
                },
                {
                    data: 'unitprice',
                    name: 'unitprice'
                },
                {
                    data: 'poqty',
                    name: 'poqty'
                },
                {
                    data: 'balancepo',
                    name: 'balancepo'
                },
                {data:'buttons', name:'buttons', orderable:false, searchable:false},
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

                // Total Billed qty
                pageTotal = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                //total balance PO 
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
                    total + " Balance PO"
                );

            }
        });

    });
</script>
@endsection