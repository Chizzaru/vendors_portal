<?php
include 'includes/connection.php';
$domain = $_SERVER['HTTP_HOST'];
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

    <title>Vendor Portal Sales Report</title>
  </head>
  <body>



    <div class="container">
    <div style="text-align:center;font-weight:bold;font-size:30px;"><img src="img/icon-lcc.png" alt="" width=100> SALES REPORT</div>
    <hr>
    <form id="report_form" method="post">
        <label for="rep_type">Report Type : </label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="rep_type" id="flexRadioDefault1" value="Store" checked>
            <label class="form-check-label" for="flexRadioDefault1">
                Store
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="rep_type" value="SKU" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
                SKU
            </label>
        </div>
        <br>
        <label for="fromdate">From:</label>
        <input type="date" class="form-control" id="fromdate" name="fromdate" required>
        <label for="todate">To:</label>
        <input type="date" class="form-control" id="todate" name="todate" required>

        <br>
        <label for="business_unit">Business Unit:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="business_unit" id="flexRadioDefault1" value="DS" checked>
            <label class="form-check-label" for="flexRadioDefault1">
                Department Store
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="business_unit" value="SMR" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
                Supermarket
            </label>
        </div>
        <br>
        <label for="vendor_code">Vendor Code:</label>
        <select class="vndr" form-control" id="vendor_code" name="vendor_code" required>

            <?php 
            $sql = mysqli_query($conn,("SELECT * FROM `tbl_vendor_master`"));
            while($row=mysqli_fetch_assoc($sql)):
            ?>
            <option value="<?php echo $row['v_code'] ?>"><?php echo $row['v_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <button id="submit" type="submit" action="submit" class="btn btn-primary">
        <span class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></span>
          Generate
        </button>
    </form>


      <div id="alert" class="text-center">
          Press "F5" to reload this page. Thank you!
      </div>
    </div>







<!-- Modal -->
<div class="modal fade" id="salesmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div style="padding:4px" type="button" class="export2excel"> <img src="img/icon-excel.png" alt="" width=20> Export to Excel</div>
        <div style="padding:4px" type="button" class="print"> <img src="img/icon-print.png" alt="" width=20> Print</div>

        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="text-center"><img src="https://static.wikia.nocookie.net/lccmalls/images/6/6a/E021f73187a1466fb471064524thumbnail.jpg" alt="" width=50> Sales Report Per Store</h5>
        
        <table id="sales_store_table" class="table table-bordered text-center" style="font-size:12px">
            <thead>
            <tr>
              <th colspan="2">
              Vendor : <span class="vcode" style="font-weight:bold;"></span> / <span class="vdesc" style="font-weight:bold;"></span>
              </th>
              <th colspan="2">
              Date Filtered : <span class="datefiltered" style="font-weight:bold;"></span>
              </th>
            </tr>
            </thead>
              <thead> 
                <tr>
                    <th>Store Code</th>
                    <th>Store Description (<span id="businessunit"></span>)</th>
                    <th>Unit Sold</th>
                    <th>Net Sales</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <div style="padding:4px" type="button" class="export2excel"> <img src="img/icon-excel.png" alt="" width=20> Export to Excel</div>
        <div style="padding:4px" type="button" class="print"> <img src="img/icon-print.png" alt="" width=20> Print</div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="js/table_export/tableExport.min.js"></script>

    <script src="js/table_export/libs/FileSaver/FileSaver.min.js"></script>
    <script src="js/table_export/libs/js-xlsx/xlsx.core.min.js"></script>
    <script src="js/table_export/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="js/table_export/libs/pdfmake/pdfmake.min.js"></script>
    <script src="js/table_export/libs/pdfmake/vfs_fonts.js"></script>

    <script src="js/table_export/libs/es6-promise/es6-promise.auto.min.js"></script>
    <script src="js/table_export/libs/html2canvas/html2canvas.min.js"></script>


    <script>
    $(document).ready(function() {
        $('.vndr').select2({
          placeholder: "Select Vendor",
          allowClear: true
        });
        $(".vndr").val('').trigger('change');
        $(".spinner").hide();
    });


    </script>

    <script src="js/generatereport.js"></script>

    <script src="js/printThis.js"></script>

    <script>
				function printModalBody() {
					$('.modal-body').printThis({
						debug: false, // show the iframe for debugging
						importCSS: true, // import parent page css
						importStyle: true, // import style tags
						printContainer: true, // print outer container/$.selector
						loadCSS: "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css", // path to additional css file - use an array [] for multiple
						pageTitle: "", // add title to print page
						removeInline: false, // remove inline styles from print elements
						removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
						printDelay: 333, // variable print delay
						header: null, // prefix to html
						footer: null, // postfix to html
						base: false, // preserve the BASE tag or accept a string for the URL
						formValues: true, // preserve input/form values
						canvas: true, // copy canvas content
						doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
						removeScripts: false, // remove script tags from print content
						copyTagClasses: false, // copy classes from the html & body tag
						beforePrintEvent: null, // callback function for printEvent in iframe
						beforePrint: null, // function called before iframe is filled
						afterPrint: null,// function called before iframe is removed
					});
				}
    </script>


  </body>
</html>