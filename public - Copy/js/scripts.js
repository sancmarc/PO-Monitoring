window.addEventListener('DOMContentLoaded', event => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});
$(document).ready(function() {
    var count = 1;
    $('#add').click(function() {
        var classlot = 'Order';
        count = count + 1;
        var html_code = "<tr id='row" + count + "'>";
        html_code += "<td><div id='status" + count + "'></div></td>";
        html_code += "<td class='prod_date'><input type='date' class='insert_date'></td>";
        html_code += "<td class='lot_no'><input type='text' id='lotcheck" + count + "' class='lotcheck'></td>";
        html_code += "<td contenteditable='true' class='priority' ></td>";
        html_code += "<td contenteditable='true' class='lotclass'>" + classlot + "</td>";
        html_code += "<td contenteditable='true' class='product_code'></td>";
        html_code += "<td contenteditable='true' class='prod_name'></td>";
        html_code += "<td contenteditable='true' id='number_only' class='lot_qty'></td>";
        html_code += "<td class='del_date'><input type='date' class='date_end'></td>";
        html_code += "<td contenteditable='true' class='note'></td>";
        html_code += "<td contenteditable='true' class='main_material' ></td>";
        html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>-</button></td>";
        html_code += "</tr>";
        $('#crud_table').append(html_code);
        $(document).ready(function() {
            // check change event of the text field
            $("#lotcheck" + count + "").keyup(function() {
                // get text username text field value
                var lotcheck = $("#lotcheck" + count + "").val();
                // check username name only if length is greater than or equal to 1
                if (lotcheck.length >= 0) {
                    $("#status" + count + "").html();
                    // check lot
                    $.post("include/check_lot.php", {
                        lotcheck: lotcheck
                    }, function(data, status) {
                        $("#status" + count + "").html(data);
                    });
                } else {
                    $("#status" + count + "").html('Input Lot');
                }
            });
        });
        $("#number_only").keypress(function(e) {
            if (isNaN(String.fromCharCode(e.which))) e.preventDefault();
        });
    });
    $(document).on('click', '.remove', function() {
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
    });
    $('#save').click(function() {
        var prod_date = [];
        var lot_no = [];
        var priority = [];
        var date_prod = [];
        var date_del = [];
        var lotclass = [];
        var product_code = [];
        var prod_name = [];
        var lot_qty = [];
        var del_date = [];
        var note = [];
        var main_material = [];
        $('.insert_date').each(function() {
            date_prod.push($(this).val());
        });
        $('.date_end').each(function() {
            date_del.push($(this).val());
        });
        $('.lotcheck').each(function() {
            lot_no.push($(this).val());
        });
        // $('.prod_date').each(function(){
        //  prod_date.push($(this).text());
        // });
        // $('.lot_no').each(function(){
        //  lot_no.push($(this).text());
        // });
        $('.priority').each(function() {
            priority.push($(this).text());
        });
        $('.lotclass').each(function() {
            lotclass.push($(this).text());
        });
        $('.product_code').each(function() {
            product_code.push($(this).text());
        });
        $('.prod_name').each(function() {
            prod_name.push($(this).text());
        });
        $('.lot_qty').each(function() {
            lot_qty.push($(this).text());
        });
        // $('.del_date').each(function(){
        //  del_date.push($(this).text());
        // });
        $('.note').each(function() {
            note.push($(this).text());
        });
        $('.main_material').each(function() {
            main_material.push($(this).text());
        });
        if (date_prod != '' && date_del != '') {
            $.ajax({
                url: "include/insert_lot.php",
                method: "POST",
                data: {
                    date_prod: date_prod,
                    lot_no: lot_no,
                    priority: priority,
                    lotclass: lotclass,
                    product_code: product_code,
                    prod_name: prod_name,
                    lot_qty: lot_qty,
                    date_del: date_del,
                    note: note,
                    main_material: main_material
                },
                success: function(data) {
                    alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                        document.location.reload(true);
                    }
                    document.location.reload(true);
                }
            });
        } else {
            alert("Date are required");
        }
    });
});