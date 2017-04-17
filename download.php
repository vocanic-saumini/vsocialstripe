<?php 

require_once ('api/init.php');

// Get the invoice id from the request
$invoiceId = $_REQUEST['invoice'];

// Retrieve invoice from Stripe
try {
	
	$invoice = \Stripe\Invoice::retrieve($invoiceId);
	
} catch (Exception $e) {
	echo json_encode(array(
			'error' => array (
				'message' => $e->getMessage()
		)
	));
	return;
}

// Retrieve customer from Stripe
try {
	
	$customer = \Stripe\Customer::retrieve('cus_AIqDGBXVvOqmyH');
	
} catch (Exception $e) {
	echo json_encode(array(
			'error' => array (
					'message' => $e->getMessage()
			)
	));
	return;
}

$invoiceNo = $invoice->receipt_number ?? $invoice->id;

$billingAddress = '';

$billingAddress .= $customer->sources->data[0]->name . '<br />';
$billingAddress .= $customer->sources->data[0]->address_line1 . '<br />';
$billingAddress .= $customer->sources->data[0]->address_city . ' ' . $customer->sources->data[0]->address_zip . '<br />';
$billingAddress .= $customer->sources->data[0]->address_country . '<br />';

$invoiceDate	= date('m/d/Y', $invoice->date);
$cardNumber		= $customer->sources->data[0]->last4;

$subtemplate	= '<tr><td>__QUANTITY__</td><td>__DESC__</td><td>__AMOUNT__</td></tr>';
$invoiceContent	= '';

for($i = 0; $i < count($invoice->lines->data); $i++) {
	$tempContent = $subtemplate;
	
	$tempContent = str_replace('__QUANTITY__', $invoice->lines->data[$i]->quantity, $tempContent);
	$tempContent = str_replace('__DESC__', $invoice->lines->data[$i]->plan->statement_descriptor, $tempContent);
	$tempContent = str_replace('__AMOUNT__', strtoupper($invoice->lines->data[$i]->currency) . ' ' . number_format($invoice->lines->data[$i]->amount / 100, 2), $tempContent);
	
	$invoiceContent .= $tempContent;
}

$totalAmount = strtoupper($invoice->currency) . number_format($invoice->total / 100, 2);

// Generate the HTML
// Not all CSS supported
// * Float doesn't support

$invoiceHtml = <<<EOF
<style>
	.row {
		margin-left: -15px;
		margin-right: -15px;
	}
	
	.col-xs-6 {
		position: relative;
  		min-height: 1px;
  		padding-left: 15px;
  		padding-right: 15px;
		float: left;
		width: 50%;
	}
	
	.col-md-4 {
		position: relative;
		min-height: 1px;
		padding-left: 15px;
		padding-right: 15px;
	}
	
	.text-center {
		text-align: center;
	}
	
	.table {
		  width: 100%;
		  max-width: 100%;
		  margin-bottom: 20px;
	}
	
	.table > thead > tr > th,
	.table > tbody > tr > th,
	.table > tfoot > tr > th,
	.table > thead > tr > td,
	.table > tbody > tr > td,
	.table > tfoot > tr > td {
		  padding: 8px;
		  line-height: 1.42857143;
		  vertical-align: top;
		  border-top: 1px solid #ddd;
	}
	
	.table > thead > tr > th {
		  vertical-align: bottom;
		  border-bottom: 2px solid #ddd;
	}
	
	.table > tbody + tbody {
		border-top: 2px solid #ddd;
	}
	
	.table-bordered {
		border: 1px solid #ddd;
	}
	
	.table-bordered > thead > tr > th,
	.table-bordered > tbody > tr > th,
	.table-bordered > tfoot > tr > th,
	.table-bordered > thead > tr > td,
	.table-bordered > tbody > tr > td,
	.table-bordered > tfoot > tr > td {
		border: 1px solid #ddd;
	}
	
	.table-bordered > thead > tr > th,
	.table-bordered > thead > tr > td {
		border-bottom-width: 2px;
	}
</style>

<table>
	<tr>
		<td>
			<div class="col-xs-6 col-md-4">
				<img src="VSocial_logo_2.png" width="130" height="70"/>
			</div>
		</td>
		
		<td>
			<div class="col-xs-6 col-md-4">
				<p class="text-center">
					Vocanic Pte Ltd.<br/>
					18 Cross Street,<br/>
					China Square Central #04-02,<br/>
					Singapore 048423<br/>
				</p>
			</div>
		</td>
		
		<td>
			<div class="col-xs-6 col-md-4 text-center">
				<h3>INVOICE/RECEIPT</h3>
				<div>Receipt Number : <strong>$invoiceNo</strong></div>
			</div>
		</td>
	</tr>
	
	<tr>
		<td>
			<table class="table table-bordered" style="width: 55%">
				<thead>
					<tr class="active">
						<th>Bill To</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td><p>$billingAddress</p></td>
					</tr>
				</tbody>
			</table>
		</td>
		
		<td></td>
		
		<td>
			<table class="table pull-right table-bordered" style="width: 75%">
				<thead>
					<tr class="active">
						<th>Date</th>
						<th>Credit Card</th>
						<th>Terms</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td>$invoiceDate</td>
						<td>$cardNumber</td>
						<td>Paid</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	
	<tr>
		<td colspan="3">
			<table class="table table-bordered">
				<colgroup>
					<col width="10%">
					<col width="65%">
					<col width="25%">
				</colgroup>
				<thead>
					<tr class="active">
						<th>Qty</th>
						<th>Description</th>
						<th>Amount</th>
					</tr>
				</thead>
				
				<tbody id="invoicelines">
					$invoiceContent
					
					<tr>
						<th></th>
						<th><strong>TOTAL : </strong></th>
						<th>$totalAmount</th>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	
	<tr>
		<td colspan="3">
			<div class="text-center">
				<p>
					Thank you for your business!<br/>
					support@vsocial.com<br/>
					(65) 6395 3080<br/>
				</p>
			</div>
		</td>
	</tr>
</table>
EOF;

// Include the main TCPDF library (search for installation path).
require_once('extension/TCPDF-6.2.13/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// output the HTML content
$pdf->writeHTML($invoiceHtml, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('PHPInvoice.pdf', 'D');


