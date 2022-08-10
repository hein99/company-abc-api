<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\CampaignRequest;
use App\Services\V1\CampaignService;

class CampaignController extends Controller
{
    /**
     * Check customer is eligible to participate this campaign
     *
     * @return \Illuminate\Http\Response
     */

    public function participate(CampaignRequest $request)
    {
        $campaign = new CampaignService;
        
        return $campaign->enterCampaign($request);
    }

    /**
     * Validate photo submission and when validation success, give voucher code to customer
     * 
     * @return \Illuminate\Http\Response
     */
    public function getVoucher(CampaignRequest $request)
    {
        $campaign = new CampaignService;

        return $campaign->getVoucher($request);
    }


}
