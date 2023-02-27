<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries List</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap5.min.css') }}">

<link rel="stylesheet" href="{{ asset('bootstrap/css/responsive.bootstrap5.min.css')}}">

<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
</head>
<body>
    <h1>Sample fetch with button</h1>
    <section class="container">
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">PO Monitoring</div>
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
                                <th>Actions</th>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align:right">Accum. Output:</th>
                                    <th></th>
                              
                                    <th ></th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                </div>
            </div>
  
        </div>
    </section>
    @include('edit-country-modal')
    <script src="{{ asset('jquery/jquery-3.6.0.min.js')}}"></script>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset('datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('datatable/js/responsive.bootstrap5.min.js')}}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('toastr/toastr.min.js')}}"></script>





    <script>


        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){
            
            $('#PO-table').DataTable({
                order:[[0, 'desc']],
                processing:true,
                serverSide:true,
     
                info:true,
                ajax:"{{ route('get.po.list') }}",
                aLengthMenu:[[10,25,50,100,-1],[10,25,50,100,"ALL"]],
                columns:[
                    // {data:'po_id', name:'po_id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'receiveddate', name:'receiveddate'},
                    {data:'modelProduct', name:'modelProduct'},
                    {data:'pn', name:'pn'},
                    {data:'pono', name:'pono'},
                    {data:'unitprice', name:'unitprice'},
                    {data:'poqty', name:'poqty'},
                    {data:'balancepo', name:'balancepo'},

                 ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\,]/g, '')*1 :
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
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                    //total balance PO 
                    total = api
                    .column( 7, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
        
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        pageTotal
                    );
                    $( api.column( 7 ).footer() ).html(
                        total + " Balance PO"
                    );
                
                }
            });
        });
    </script>
</body>
</html>