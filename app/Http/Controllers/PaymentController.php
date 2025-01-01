<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function projectPayment(Request $request)
    {
        $data = new Payment();
        $data->project_id = $request->project_id;
        $data->payment_date = Carbon::parse($request->payment_date)->format('Y-m-d');
        $data->total_payment = $request->total_payment;

        $data->save();
        return redirect()->back();
    }

    public function getPaymentDetails(Request $request)
    {
        $projectId = $request->get('project_id');

        // Fetch project details
        $project = Project::findOrFail($projectId);

        // Fetch payment details for the project
        $paymentDetails = Payment::where('project_id', $projectId)
        ->orderBy('payment_date', 'asc')
        ->get();

        // Calculate total payment made
        $totalPaid = $paymentDetails->sum('total_payment');

        // Calculate remaining balance
        $remainingBalance = $project->total_earning - $totalPaid;

        // Return response with total earning included
        return response()->json([
            'payment_details' => $paymentDetails->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'date' => $payment->payment_date,
                    'amount' => $payment->total_payment,
                ];
            }),
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
            'total_earning' => $project->total_earning,  // Include total_earning here
        ]);
    }

    public function deletePayment(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $payment = Payment::findOrFail($paymentId);
        $payment->delete();

        // Fetch updated payment details
        $projectId = $payment->project_id;
        $paymentDetails = Payment::where('project_id', $projectId)->get();
        $project = Project::findOrFail($projectId);
        $totalPaid = $paymentDetails->sum('total_payment');
        $remainingBalance = $project->total_earning - $totalPaid;

        return response()->json([
            'status' => 'success',
            'message' => 'Payment deleted successfully.',
            'payment_details' => $paymentDetails,
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
        ]);
    }

    // Update Payment
    public function updatePayment(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $newAmount = $request->get('amount');
        $newDate = $request->get('payment_date');

        $payment = Payment::findOrFail($paymentId);
        $payment->total_payment = $newAmount;
        $payment->payment_date = Carbon::parse($newDate)->format('Y-m-d');
        $payment->save();

        // Fetch updated payment details
        $projectId = $payment->project_id;
        $paymentDetails = Payment::where('project_id', $projectId)->get();
        $project = Project::findOrFail($projectId);
        $totalPaid = $paymentDetails->sum('total_payment');
        $remainingBalance = $project->total_earning - $totalPaid;

        return response()->json([
            'status' => 'success',
            'message' => 'Payment updated successfully.',
            'payment_details' => $paymentDetails,
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
        ]);
    }
}
