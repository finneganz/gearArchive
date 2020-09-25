<?php

namespace App\Http\Controllers;

use App\Models\Devices\Maker;
use Illuminate\Http\Request;
use App\Http\Requests\AddDeviceRequest;
use App\Http\Requests\EditDeviceRequest;
use Illuminate\Routing\Router;
use App\Domains\DeviceDomain;

class DeviceController extends BaseController
{
    public function showDeviceList()
    {
        $isLoggedIn = $this->authCheck();
        $deviceDomain = new DeviceDomain;
        $devices = $deviceDomain->getSomeDevices();
        $devices = json_encode($devices);
        return view('devices.list', compact('devices', 'isLoggedIn'));
    }
    public function showDeviceGenre(Router $router)
    {
        // ルートパラメータを取得
        $routeParam = $router->getCurrentRoute()->parameters();
        $deviceGenreParam = $routeParam['device'];
        $deviceDomain = new DeviceDomain;
        $devices = $deviceDomain->getDeviceOfGenre($deviceGenreParam);
        $isLoggedIn = $this->authCheck();
        
        return view('devices.genre', compact('devices','deviceGenreParam', 'isLoggedIn'));
    }
    public function showDeviceProduct(Router $router)
    {
        // ルートパラメータを取得
        $routeParams = $router->getCurrentRoute()->parameters();
        $deviceDomain = new DeviceDomain;
        $device = $deviceDomain->getProductOfDevice($routeParams);
        $device->device_name = str_replace('_', ' ', $device->device_name);
        $device->maker_name = $device->getMaker->maker_name;
        $isLoggedIn = $this->authCheck();

        return view('devices.product', compact('device', 'isLoggedIn'));
    }

    // 管理者用
    public function showDeviceAddPage()
    {
        $isLoggedIn = $this->authCheck();
        return view('devices.add', compact('isLoggedIn'));
    }
    public function addDevice(AddDeviceRequest $request)
    {
        $deviceDomain = new DeviceDomain;
        $device = $deviceDomain->addNewDevice($request);
        $deviceDomain->save($device);

        return redirect()->action('DeviceController@showDeviceList');
    }
    public function showDeviceEditPage(Router $router)
    {
        $routeParams = $router->getCurrentRoute()->parameters();
        $deviceDomain = new DeviceDomain;
        $device = $deviceDomain->getProductOfDevice($routeParams);
        $device->maker_name = $device->getMaker->maker_name;
        $isLoggedIn = $this->authCheck();

        return view('devices.edit', compact('device', 'isLoggedIn'));
    }
    public function editDevice(Router $router, EditDeviceRequest $request)
    {
        $routeParams = $router->getCurrentRoute()->parameters();
        $deviceDomain = new DeviceDomain;
        $device = $deviceDomain->getProductOfDevice($routeParams);
        $device->device_name = $request->input('deviceName');
        $device->maker_id = Maker::where('maker_name', $request->input('makerName'))->first()->id;
        $deviceDomain->save($device);

        return redirect()->action('DeviceController@showDeviceList');
    }
}
