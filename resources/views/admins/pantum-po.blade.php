@extends('layouts.dashboard')

@section('content')
<section class="container">
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">PO Monitor Pantum</div>
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
                              
                                    <th ></th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
    <script>
    toastr.options.preventDuplicates = true;

   $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        
    $(function(){
        
        //ADD PO


            $('#PO-table').DataTable({
                order:[[0, 'desc']],
                processing:true,
                serverSide:true,
                responsive:true,
                info:true,
                bAutoWidth:false,
                ajax:"{{ route('po.list.pantum') }}",
                aLengthMenu:[[10,25,50,100,-1],[10,25,50,100,"ALL"]],
                columns:[
                    // {data:'id', name:'id'},
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
@endsection