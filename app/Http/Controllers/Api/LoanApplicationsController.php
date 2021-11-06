<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanApplicationStoreRequest;
use App\Http\Requests\LoanApplicationUpdateRequest;
use App\Http\Resources\LoanApplicationResource;
use App\Http\Resources\LoanApplicationResourceCollection;
use App\Models\LoanApplication;
use App\Services\LoanApplicationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoanApplicationsController extends Controller
{
    use ApiResponseTrait;

    protected $loanApplicationService;

    /**
     * __construct
     *
     * @param LoanApplicationService $loanApplicationService
     * @return void
     */
    public function __construct(LoanApplicationService $loanApplicationService)
    {
        $this->middleware('auth:api', []);
        $this->loanApplicationService = $loanApplicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = LoanApplication::where('user_id', auth()->id())->get();
        return $this->responseSuccessJson(new LoanApplicationResourceCollection($collection));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LoanApplicationStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanApplicationStoreRequest $request)
    {
        $user = auth()->user();
        $params = $request->all();
        $loanAmount = $params['loan_amount'];
        $loanTerm = $params['loan_term'];
        $description = $params['description'] ?? null;
        $loanApplication = $this->loanApplicationService->add($user, $loanAmount, $loanTerm, $description);
        return $this->responseSuccessJson(new LoanApplicationResource($loanApplication));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $loanApplication = LoanApplication::findOrFail($id);
            return $this->responseSuccessJson(new LoanApplicationResource($loanApplication));
        } catch (ModelNotFoundException $er) {
            return $this->responseFailJson(__('messages.item_not_found'), null);
        } catch (\Exception $er) {
            return $this->responseFailJson(__('messages.process_error'), null);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LoanApplicationUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LoanApplicationUpdateRequest $request, $id)
    {
        try {
            $params = $request->all();
            $loanApplication = LoanApplication::findOrFail($id);

            if ($request->user()->cannot('update', $loanApplication)) {
                return $this->responseFailJson(__('messages.permission_denied'), null, Response::HTTP_FORBIDDEN);
            }

            $loanApplication = $this->loanApplicationService->update($loanApplication, $params);
            return $this->responseSuccessJson(new LoanApplicationResource($loanApplication));
        } catch (ModelNotFoundException $er) {
            return $this->responseFailJson(__('messages.item_not_found'), null);
        } catch (\Exception $er) {
            Log::error($er->__toString());
            return $this->responseFailJson(__('messages.process_error'), null);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $loanApplication = LoanApplication::findOrFail($id);
            $loanApplication->delete();
            return $this->responseSuccessJson(null, 'successful');
        } catch (ModelNotFoundException $er) {
            return $this->responseFailJson(__('messages.item_not_found'), null);
        } catch (\Exception $er) {
            Log::error($er->getMessage());
            return $this->responseFailJson(__('messages.process_error'), null);
        }
    }
}
