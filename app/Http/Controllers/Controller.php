<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send a standardized JSON success response.
     */
    protected function success($data = [], string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Send a standardized JSON error response.
     */
    protected function error(string $message = 'An error occurred', int $code = 400, $data = []): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }


    // public function __invoke(EmailVerificationRequest $request)
    // {
    //     $request->fulfill();
    //     return redirect('/dashboard'); // Or wherever you want
    // }


    /**
     * Log an action for debug or audit purposes.
     */
    protected function logAction(string $context, array $data = []): void
    {
        Log::info("[$context]", $data);
    }
}


// namespace App\Http\Controllers;

// abstract class Controller
// {
//     //
// }
