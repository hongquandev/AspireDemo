<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentChargeRequest;
use App\Http\Resources\LoanPaymentOrderResource;
use App\Models\LoanApplication;
use App\Services\LoanApplicationService;
use App\Services\LoanPaymentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class LoanPaymentController extends Controller
{
    use ApiResponseTrait;

    protected $loanPaymentService;

    /**
     * __construct
     *
     * @param LoanPaymentService $loanPaymentService
     * @return void
     */
    public function __construct(LoanPaymentService $loanPaymentService)
    {
        $this->middleware('auth:api', []);
        $this->loanPaymentService = $loanPaymentService;
    }

    /**
     * charge
     *
     * @param PaymentChargeRequest $request
     * @return void
     */
    public function charge(PaymentChargeRequest $request)
    {
        try {
            $user = auth()->user();
            $params = $request->all();
            $loanApplicationId = $params['loan_application_id'];
            $loanApplication = LoanApplication::findOrFail($loanApplicationId);

            if ($loanApplication->status != LoanApplicationService::APPOVED_STATUS) {
                return $this->responseFailJson(__('loan.not_approved'), null);
            }

            $loanPaymentOrder = $this->loanPaymentService->add($user, $loanApplication, $loanApplication->weeklyAmount());
            return $this->responseSuccessJson(new LoanPaymentOrderResource($loanPaymentOrder));
        } catch (ModelNotFoundException $er) {
            return $this->responseFailJson(__('messages.item_not_found'), null);
        } catch (\Exception $er) {
            Log::error($er->getMessage());
            return $this->responseFailJson(__('messages.process_error'), null);
        }
    }
}
