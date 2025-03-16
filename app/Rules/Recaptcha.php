<?php

namespace App\Rules;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => env('GOOGLE_RECAPTCH_SECRET_KEY'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]
            ]);

            $response = json_decode($response->getBody());
            if ($response->success === false) {
                $fail('reCAPTCHA verification failed due to an error.');
            }

        } catch (\Exception $e) {
            //log error
            $fail('reCAPTCHA verification failed due to an error.');
        }
    }
}
