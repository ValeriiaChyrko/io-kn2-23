<?php

namespace App\Http\Controllers\Api\License;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseCopyRequest;
use App\Models\License;
use Illuminate\Http\JsonResponse;

class LicenseCopyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LicenseCopyRequest $request
     * @param License $license
     * @return JsonResponse
     */
    public function __invoke(LicenseCopyRequest $request, License $license): JsonResponse
    {
        $config = $request->validated();

        $licenses = collect();

        for ($i = 1; $i <= $config['count']; $i++) {
            $copy = $license->replicate();
            $copy->save();

            $licenses->push($copy);
        }

        return response()->json($licenses);
    }
}
