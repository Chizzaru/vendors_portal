<?php

include 'connection.php';
include 'functions.php';

$rep_type = $_POST['rep_type'];
$fromdate = encodeDate($_POST['fromdate']);
$todate = encodeDate($_POST['todate']);
$business_unit = $_POST['business_unit'];
$vendor_code = $_POST['vendor_code'];

$output = array();
if ($rep_type == 'Store') {
    $sql = mysqli_query($conn,("CALL genSalesReportByYear(".$fromdate.", ".$todate.",'".$business_unit."',".$vendor_code.")"));
    while($row = mysqli_fetch_assoc($sql)) {
        $output[] = array(
            'store_code' => $row['store_id'],
            'store_name' => $row['store_name'],
            'unit_sold' => $row['unit_sold'],
            'net_sales' => $row['net_sales']
        );
    }
}

if($rep_type == 'SKU') {
    
}

echo json_encode($output);