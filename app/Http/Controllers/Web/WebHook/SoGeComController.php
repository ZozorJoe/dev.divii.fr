<?php

namespace App\Http\Controllers\Web\WebHook;

use App\Http\Controllers\Controller;
use App\Services\Sogecom;
use Exception;

class SoGeComController extends Controller
{

    /**
     * Handle ipn notification
     * @throws Exception
     */
    public function index(Sogecom $sogecom)
    {
        info('IPN: ---> START');

        if (empty($_POST)){
            error_log('POST is empty');

            return response('POST is empty');
        }

        info('IPN: Data Received ' . json_encode($_POST));

        if (isset($_POST['vads_hash'])){
            $sogecom->handleIpn($_POST);

            return response('Form API notification detected');
        }

        if (isset($_POST['kr-hash'])&& isset($_POST['kr-hash-algorithm']) && isset($_POST['kr-answer'])){
            $sogecom->handleIpn($_POST);

            return response('REST API notification detected');
        }

        error_log('IPN: --> KO');

        return response('KO');
    }
}
