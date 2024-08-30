<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadRecipeRequest;
use App\Library\Hubspot\HomechefLibrary;
use App\Models\RequestDownload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestDownloadForm extends Controller
{
    public function store(DownloadRecipeRequest $request) {
        $validated = $request->validated();

        $homeChef = new HomechefLibrary();

        $geoIp = geoip()->getLocation();

        $overall_opt_in_status = $validated['overall_opt_in_status'] == true || $validated['overall_opt_in_status'] == 'true' || $validated['overall_opt_in_status'] == 'on' ? 'true' : 'false';

        $data = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'city' => $validated['city'],
            'phone' => $validated['phone'],
            'cid' => $validated['cid'],
            'type_of_signup' => $validated['type_of_signup'] ?? 'Manual signup',
            'overall_opt_in_status' => (string) $overall_opt_in_status,
            'tnc' => $validated['tnc'],
            'hutk' => $validated['hutk'] ?? '',
            'latitude' => $validated['latitude'] ?? $geoIp->lat,
            'longitude' => $validated['longitude'] ?? $geoIp->lon,
            'pageName' => $validated['page'] ?? '',
            'pageUri' => $validated['page_url'] ?? ''
        ];

        $response = $homeChef->store_form_request($data);

        DB::beginTransaction();
        try {

            // get birthdate from validated date_of_birth, yyyy-mm-dd string, then parse it to age
            $birthDate = Carbon::parse($validated['date_of_birth'])->age;

            $formData = [
                'full_name' => $data['firstname'] . ' ' . $data['lastname'],
                'age' => $birthDate,
                'email' => $data['email'],
                'additional_information' => $data
            ];

            RequestDownload::create($formData);

        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            DB::rollBack();
        }

        DB::commit();

        return [
            'message' => 'success',
            'response' => $response
        ];
    }

    public function store_test(DownloadRecipeRequest $request) {

        // get all cookie from the request
        // dd($request->cookie('hubspotutk'));


        $homeChef = new HomechefLibrary();
        $validated = $request->validated();
        $geoIp = geoip()->getLocation();
        $overall_opt_in_status = $validated['overall_opt_in_status'] == true || $validated['overall_opt_in_status'] == 'true' || $validated['overall_opt_in_status'] == 'on' ? 'true' : 'false';

        $data = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'city' => $validated['city'],
            'phone' => $validated['phone'],
            'cid' => $validated['cid'],
            'type_of_signup' => $validated['type_of_signup'] ?? 'Manual signup',
            'overall_opt_in_status' => (string) $overall_opt_in_status,
            'tnc' => $validated['tnc'],
            'hutk' => $validated['hutk'] ?? '',
            'latitude' => $validated['latitude'] ?? $geoIp->lat,
            'longitude' => $validated['longitude'] ?? $geoIp->lon,
            'pageName' => $validated['page'] ?? '',
            'pageUri' => $validated['page_url'] ?? ''
        ];

        $response = $homeChef->store_form_request($data);

        return [
            'message' => 'success',
            'contact' => $data,
            'response' => $response
        ];


        // DB::beginTransaction();

        // try {
        //     $form = RequestDownload::create($request->validated());
        // } catch (\Throwable $th) {
        //     throw $th;

        //     DB::rollBack();
        // }

        // $data = [
        //     'message' => 'success',
        //     'contact' => $form
        // ];

        // DB::rollBack();

        // return $data;
    }
}
