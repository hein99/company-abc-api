<?php

namespace App\Services\V1;

use App\Models\Customer;
use App\Models\PurchaseTransaction;
use App\Models\Voucher;
use App\Http\Requests\V1\CampaignRequest;

class CampaignService
{
    /**
     * @param App\Http\Requests\V1\CampaignRequest
     * @return \Illuminate\Http\Response
     */
    public function enterCampaign(CampaignRequest $request)
    {
        # Check customer whether exit or not in database
        if(!$customer = Customer::find($request->customer_id)) {

            return response()->json([
                'meta' => [
                    'customer_id' => $request->customer_id,
                ],
                'errors' => [
                    'message' => "Customer with id " . $request->customer_id . " doesn't exist."
                ]
            ], 404);
        }

        # Unlock all vouchers that are locked down out of time.
        $this->unlockLockedDownExpiredVouchers();

        # Check Available Voucher in database
        if(!$this->checkAvailableVoucher()) {

            return response()->json([
                'meta' => [
                    'success' => false,
                ],
                'errors' => [
                    'code' => 1,
                    'message' => "Vouchers are fully redeemed or locked down.",
                ],
            ], 200);
        }

        # Check customer is eligible to participate this campaign
        if($error_message = $this->checkEligibilityToParticipate($request->customer_id)) {

            return response()->json([
                'meta' => [
                    'customer_id' => $request->customer_id,
                    'success' => false,
                ],
                'errors' => [
                    'code' => 2,
                    'message' => $error_message,
                ],
            ], 200);

        } 

        # Lock down a voucher when customer is eligible
        $this->lockDownAVoucher($request->customer_id);

        return response()->json([
            'meta' => [
                'customer_id' => $request->customer_id,
                'success' => true,
                'message' => "Locked down a voucher. Need to send a qualified photo within 10 minutes to redeem it.",
            ],
        ], 200);
    }

    /**
     * Unlock all vouchers that are locked down out of times.
     */
    private function unlockLockedDownExpiredVouchers()
    {
        $vouchers = Voucher::where('status', 'locked')->where('locked_down_expired_at', '<', date('Y-m-d H:i:s'))->get();
        
        foreach( $vouchers as $voucher ) {
            $voucher->customer_id = null; 
            $voucher->status = 'available';
            $voucher->locked_down_expired_at = null;
            $voucher->save();
        }
    }

    /**
     * Find Available Voucher from database
     * 
     * @return Boolean
     */
    private function checkAvailableVoucher() 
    {
        $voucher = Voucher::where('status', 'available')->first();

        return $voucher ? true : false;
    }

    /**
     * Check customer is eligible to participate with 3 criteria
     * 
     * @param Integer ($customer_id)
     * @return String
     */
    private function checkEligibilityToParticipate($customer_id)
    {
        if(Voucher::where('customer_id', $customer_id)->first()) 
            return "Each customer is allowed to redeem 1 cash voucher only.";

        
        $start_date = date('Y-m-d', strtotime("-30 days"));
        $transactions = PurchaseTransaction::where('customer_id', $customer_id)->where('transaction_at', '>=', $start_date)->get();
        
        if( count($transactions) < 3 ) 
            return "Customer with id " . $customer_id . " haven't completed 3 purchase transactions within the last 30 days.";

        $total = PurchaseTransaction::where('customer_id', $customer_id)->where('transaction_at', '>=', $start_date)->sum('total_spent');
        if( $total < 100 )
            return "Total transactions equal or more than $100.";

        return "";
    }

    /**
     * Lock Down a voucher for 10 minutes for customer who is eligible for participation
     * 
     * @param Integer ($customer_id)
     */
    private function lockDownAVoucher($customer_id)
    {
        $voucher = Voucher::where('status', 'available')->first();

        $voucher->customer_id = $customer_id;
        $voucher->status = 'locked';
        $voucher->locked_down_expired_at = date('Y-m-d H:i:s', strtotime("+10 minutes"));
        $voucher->save();
    }


}