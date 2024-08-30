<?php

namespace App\Library\Hubspot;

use Illuminate\Support\Facades\Http;

class HomechefLibrary
{
    public function store_form_request($data = []) {

        $access_token = config('homechef-hubspot.access_token');
        $form_id = config('homechef-hubspot.form_id');
        $portal_id = config('homechef-hubspot.portal_id');
        $endpoint = config('homechef-hubspot.endpoint');

        $authHeader = "Authorization: Bearer $access_token";

        // Init URL
        $url = "$endpoint/$portal_id/$form_id";

        // Make Header
        $header = [
            $authHeader,
            'Content-Type: application/json'
        ];

        $cid = $data['cid'];

        // Make Body
        $body = [
            'fields' => [
                [
                    'objectTypeId' => '0-1',
                    'name' => 'firstname',
                    'value' => $data['firstname']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'lastname',
                    'value' => $data['lastname']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'email',
                    'value' => $data['email']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'date_of_birth',
                    'value' => $data['date_of_birth']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'city',
                    'value' => $data['city']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'phone',
                    'value' => $data['phone']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'tnc',
                    'value' => (string) $data['tnc']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'overall_opt_in_status',
                    'value' => (string) $data['overall_opt_in_status']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'type_of_signup',
                    'value' => $data['type_of_signup']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'map_latitude',
                    'value' => $data['latitude']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'map_longitude',
                    'value' => $data['longitude']
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'cid',
                    'value' => $cid
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'utm_campaign',
                    'value' => "Bundakraft Homechef 2024"
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'utm_source',
                    'value' => "Bundakraft"
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'utm_medium',
                    'value' => "Homechef"
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'utm_source',
                    'value' => "Bundakraft"
                ],
                [
                    'objectTypeId' => '0-1',
                    'name' => 'utm_term',
                    'value' => "Homechef"
                ]
            ],
            'context' => [
                'hutk' => $data['hutk'],
                'pageUri' => $data['pageUri'],
                'pageName' => $data['pageName']
            ],
            'legalConsentOptions' => [
                'consent' => [
                    "consentToProcess" => true,
                    "text" => "Dengan melanjutkan proses registrasi, Anda telah membaca dan menyetujui Ketentuan Penggunaan & Kebijakan Privasi",
                    "communications" => [
                        [
                            "value" => true,
                            "subscriptionTypeId" => 12124569,
                            "text" => "Saya setuju untuk menerima informasi tentang komunikasi pemasaran dan promosi dari Mondelez International"
                        ]
                    ]
                ]
            ]

        ];

        $cookies = [
            // '__cf_bm' => '0MPFBhjtEb2KVrKECUSfZ8kILFnl6KgnntKm2NrZYs4-1724211212-1.0.1.1-npWgUXZE4mdry4NSV2pzv6zlWrhIgVDZqN9m11x2gDhLLqxgcP9zquBNtDkPFCb2MiLi3pUgSmhLgEdyzhDq1w',
            // '_cfduid' => 'dMY5rLDHONYBKf_5R3GBK1snF3GrlhmnXPPKjhl4ux8-1724211212367-0.0.1.1-604800000',
        ];


        $body = json_encode($body);

        //  curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookies, '', '; '));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }


}
