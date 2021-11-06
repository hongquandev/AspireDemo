<?php

namespace App\Services;

use App\Models\LoanApplication;
use App\Models\User;

class LoanApplicationService
{
    public const PENDING_STATUS = 'pending';
    public const APPOVED_STATUS = 'approved';
    public const REJECTED_STATUS = 'rejected';

    protected static $instance;

    /**
     * Singleton creation
     *
     * @return LoanApplicationService
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * add
     *
     * @param User $user
     * @param mixed $loanAmount
     * @param mixed $loanTerm
     * @param mixed $description
     * @return LoanApplication|null
     */
    public function add(User $user, $loanAmount, $loanTerm, $description = null)
    {
        $loanApplication = LoanApplication::create([
            'user_id' => $user->id,
            'loan_amount' => $loanAmount,
            'loan_term' => $loanTerm,
            'description' => $description,
            'status' => self::PENDING_STATUS,
        ]);
        return $loanApplication;
    }

    /**
     * update
     *
     * @param mixed $id
     * @param mixed $params
     * @return LoanApplication|null
     */
    public function update(LoanApplication $loanApplication, $params = [])
    {
        $loanApplication->loan_amount = $params['loan_amount'];

        if (!empty($params['loan_term'])) {
            $loanApplication->loan_term = $params['loan_term'];
        }

        if (!empty($params['description'])) {
            $loanApplication->description = $params['description'];
        }

        if (!empty($params['status'])) {
            $loanApplication->status = $params['status'];
            if (in_array($params['status'], [self::APPOVED_STATUS, self::REJECTED_STATUS])) {
                $loanApplication->approved_by_id = auth()->id();
            }
        }

        $loanApplication->save();
        return $loanApplication;
    }
}
