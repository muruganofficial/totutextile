<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\VendorEarning;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ReportManager extends Component
{
    public float $dailySales = 0.00;
    public float $monthlySales = 0.00;
    public float $yearlySales = 0.00;

    public float $totalGstCollected = 0.00;
    public float $totalCommissionsEarned = 0.00;

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            return $this->redirect('/login', navigate: true);
        }

        $this->loadReportData();
    }

    public function loadReportData()
    {
        $this->dailySales = Order::whereDate('created_at', now()->toDateString())->where('payment_status', 'Paid')->sum('total');
        $this->monthlySales = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('payment_status', 'Paid')->sum('total');
        $this->yearlySales = Order::whereYear('created_at', now()->year)->where('payment_status', 'Paid')->sum('total');

        $this->totalGstCollected = Order::where('payment_status', 'Paid')->sum('tax');
        $this->totalCommissionsEarned = VendorEarning::sum('commission_deducted');
    }

    public function downloadPdfReport()
    {
        $html = "
        <style>
            body { font-family: sans-serif; color: #333; }
            h1 { color: #f59e0b; text-align: center; }
            .metric-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .metric-table th, .metric-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
            .metric-table th { bg-color: #f3f4f6; }
            .footer { margin-top: 50px; text-align: center; font-size: 11px; color: #999; }
        </style>
        <h1>Luxora Textiles - Sales Performance Report</h1>
        <p>Generated on: " . now()->format('Y-M-d h:i A') . "</p>
        <hr/>
        <table class='metric-table'>
            <thead>
                <tr>
                    <th>Reporting Metric</th>
                    <th>Collected Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Daily Sales Revenue (Today)</td>
                    <td>INR " . number_format($this->dailySales, 2) . "</td>
                </tr>
                <tr>
                    <td>Monthly Sales Revenue</td>
                    <td>INR " . number_format($this->monthlySales, 2) . "</td>
                </tr>
                <tr>
                    <td>Yearly Sales Revenue</td>
                    <td>INR " . number_format($this->yearlySales, 2) . "</td>
                </tr>
                <tr>
                    <td>Cumulative GST Tax Collected</td>
                    <td>INR " . number_format($this->totalGstCollected, 2) . "</td>
                </tr>
                <tr>
                    <td>Platform Vendor Commissions Earned</td>
                    <td>INR " . number_format($this->totalCommissionsEarned, 2) . "</td>
                </tr>
            </tbody>
        </table>
        <div class='footer'>
            &copy; " . date('Y') . " Luxora Textiles Shop Management System. Confidentially Printed.
        </div>
        ";

        $pdf = Pdf::loadHTML($html);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "sales-report-" . now()->format('Y-m-d') . ".pdf"
        );
    }

    public function render()
    {
        return view('livewire.admin.report-manager');
    }
}
