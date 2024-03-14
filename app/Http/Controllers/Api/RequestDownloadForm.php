<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadRecipeRequest;
use App\Models\RequestDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestDownloadForm extends Controller
{
    public function store(DownloadRecipeRequest $request) {


        DB::beginTransaction();

        try {
            $form = RequestDownload::create($request->validated());
        } catch (\Throwable $th) {
            throw $th;

            DB::rollBack();
        }

        DB::commit();

        return [
            'message' => 'success',
            'contact' => $form
        ];
    }

    public function store_test(DownloadRecipeRequest $request) {


        DB::beginTransaction();

        try {
            $form = RequestDownload::create($request->validated());
        } catch (\Throwable $th) {
            throw $th;

            DB::rollBack();
        }

        $data = [
            'message' => 'success',
            'contact' => $form
        ];

        DB::rollBack();

        return $data;
    }
}
