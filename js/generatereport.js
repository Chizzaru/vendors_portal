$('#alert').hide();

$(document).ready(function(){
    $('#report_form').submit(function(e){
        $(".spinner").show();
        $('#submit').attr('disabled', true);
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type : "POST",
            url : "includes/retrieve_sales_report.php",
            data : formData,
            dataType : 'json',
            success : function(data){
                $('#salesmodal').modal('show');

                var sales_store_data = '';

                $.each(data, function(key, value){
                    sales_store_data += '<tr>';
                    sales_store_data += '<td>' + value.store_code + '</td>';
                    sales_store_data += '<td>' + value.store_name + '</td>';
                    sales_store_data += '<td>' + parseFloat(value.unit_sold).toFixed(2) + '</td>';
                    sales_store_data += '<td>' + parseFloat(value.net_sales).toFixed(2) + '</td>';
                    sales_store_data += '</tr>';
                });

                //for total unit sold
                var total_unit_sold = 0;
                $(data).each(function(i){
                    total_unit_sold = total_unit_sold + parseFloat(data[i].unit_sold);
                });

                //for total unit net sales
                var total_net_sales = 0;
                $(data).each(function(i){
                    total_net_sales = total_net_sales + parseFloat(data[i].net_sales);
                });                

                sales_store_data += '<tr>';
                sales_store_data += '<td style="font-weight:bold;" colspan="2">TOTAL</td>';
                sales_store_data += '<td style="font-weight:bold;">' + total_unit_sold.toFixed(2) + '</td>';
                sales_store_data += '<td style="font-weight:bold;">' + total_net_sales.toFixed(2) + '</td>';
                sales_store_data += '</tr>';

                

                var v_code = $('#vendor_code option:selected').val();
                var v_desc = $('#vendor_code option:selected').html();
                var fdate = $('#fromdate').val();
                var tdate = $('#todate').val();
                var datefiltered = fdate + ' to ' + tdate;
                var bunit = $("input[name='business_unit']:checked").val();

                $('#sales_store_table tbody').append(sales_store_data);
                $('.vcode').html(v_code);
                $('.vdesc').html(v_desc);
                $('.datefiltered').html(datefiltered);
                $('#businessunit').html(bunit);
                $('#sales_store_table').attr('data-toggle','table');
                $('#report_form').hide();
                $('#alert').show();
            }
        });   
    });
});

$(document).ready(function(){
    $('.print').on('click',function(){
        printModalBody()
    });
});

$(document).ready(function(){
    $('.export2excel').on('click',function(){
        var x = $('#fromdate').val();
        var y = $('#todate').val();
        $('#sales_store_table').tableExport({
            type:'excel',
            fileName: 'Sales_Report_by_Store_' + x + '_to_' + y
        });
    });
});


