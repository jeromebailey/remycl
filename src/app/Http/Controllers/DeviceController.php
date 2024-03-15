<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DeviceController extends Controller
{
    //
    public function index()
    {
        if (! Gate::allows('view-all-devices', Auth::user())) {
            abort(403);
        }

        $devices = Device::getAllDevices();

        $data = array(
            'viewTitle' => 'All Devices',
            'devices' => $devices
        );
        return view('devices.all-devices', $data);
    }

    public function deviceDetails($uid)
    {
        if (! Gate::allows('view-device-details', Auth::user())) {
            abort(403);
        }

        if( $uid === null ){
            abort(404);
        } else {
            try{
                $details = Device::getDeviceByUID($uid);
                $data = array(
                    'device_details' => $details[0]
                );
                return view('devices.device-details', $data);
            } catch( Exception $e ){
                dd($e);
                Log::channel('custom_db_error_log')
                ->error(get_class($this), __METHOD__, 'Exception occurred: ' . $e->getMessage(), ['exception' => $e]);
                abort(404);
            }
        }
    }

    public function deviceStock()
    {
        if (! Gate::allows('view-device-details', Auth::user())) {
            abort(403);
        }

        try{
            $details = Device::getDeviceStockItems();
            $data = array(
                'stock' => $details
            );
            return view('devices.device-stock', $data);
        } catch( Exception $e ){
            dd($e);
            Log::channel('custom_db_error_log')
            ->error(get_class($this), __METHOD__, 'Exception occurred: ' . $e->getMessage(), ['exception' => $e]);
            abort(404);
        }
    }
}
