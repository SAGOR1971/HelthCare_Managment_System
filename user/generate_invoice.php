<?php
session_start();
include('../connect/config.php');

if (!isset($_SESSION['invoice_data'])) {
    header("Location: index.php");
    exit();
}

$invoice_data = $_SESSION['invoice_data'];

// Create PDF using TCPDF
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Healthcare Store');
$pdf->SetAuthor('Healthcare Store');
$pdf->SetTitle('Invoice #' . $invoice_data['order_id']);

// Remove header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add logo
$pdf->Image('../admin/logo.png', 10, 10, 30);

// Add header
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, 'Healthcare Store', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);

// Add invoice details
$pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');
$pdf->Ln(10);

// Add order details
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 7, 'Invoice #:', 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 7, $invoice_data['order_id'], 0, 1);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 7, 'Date:', 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 7, date('M j, Y g:i A', strtotime($invoice_data['order_date'])), 0, 1);
$pdf->Ln(10);

// Add customer details
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 7, 'Customer Details:', 0, 1);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(40, 7, 'Name:', 0);
$pdf->Cell(0, 7, $invoice_data['user_name'], 0, 1);
$pdf->Cell(40, 7, 'Email:', 0);
$pdf->Cell(0, 7, $invoice_data['user_email'], 0, 1);
$pdf->Cell(40, 7, 'Phone:', 0);
$pdf->Cell(0, 7, $invoice_data['user_phone'], 0, 1);
$pdf->Cell(40, 7, 'Address:', 0);
$pdf->MultiCell(0, 7, $invoice_data['delivery_address'], 0, 'L');
$pdf->Ln(10);

// Add order summary
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 7, 'Order Summary:', 0, 1);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(40, 7, 'Total Amount:', 0);
$pdf->Cell(0, 7, number_format($invoice_data['total_amount'], 2) . ' TaKa', 0, 1);
$pdf->Cell(40, 7, 'Payment Method:', 0);
$pdf->Cell(0, 7, ucfirst($invoice_data['payment_method']), 0, 1);
if ($invoice_data['reward_points_used'] > 0) {
    $pdf->Cell(40, 7, 'Points Used:', 0);
    $pdf->Cell(0, 7, number_format($invoice_data['reward_points_used'], 2), 0, 1);
}
$pdf->Cell(40, 7, 'Points Earned:', 0);
$pdf->Cell(0, 7, number_format($invoice_data['reward_points_earned'], 2), 0, 1);

// Add footer
$pdf->SetY(-40);
$pdf->SetFont('helvetica', 'I', 10);
$pdf->Cell(0, 7, 'Thank you for shopping with us!', 0, 1, 'C');
$pdf->Cell(0, 7, 'For any queries, please contact our support team.', 0, 1, 'C');

// Output the PDF
$pdf->Output('Invoice_' . $invoice_data['order_id'] . '.pdf', 'D');

// Clear the invoice data from session
unset($_SESSION['invoice_data']);
?> 