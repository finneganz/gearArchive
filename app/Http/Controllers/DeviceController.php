<?php

namespace App\Http\Controllers;

use App\Models\Devices\Maker;
use App\Http\Requests\AddDeviceRequest;
use App\Http\Requests\EditDeviceRequest;
use App\Domains\DeviceDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Router;

class DeviceController extends BaseController
{
    public function showDeviceList()
    {
        $auth = $this->getAuthUser();
        $deviceDomain = new DeviceDomain;
        $devices = $deviceDomain->getSomeDevices();
        $devices = json_encode($devices);
        return view('devices.list', compact('devices', 'auth'));
    }
    public function showDeviceGenre(Router $router)
    {
        // ルートパラメータを取得
        $routeParam = $router->getCurrentRoute()->parameters();
        $deviceGenreParam = $routeParam['device'];
        $deviceDomain = new DeviceDomain;
        $devices = $deviceDomain->getDeviceOfGenre($deviceGenreParam);
        $auth = $this->getAuthUser();
        
        return view('devices.genre', compact('devices','deviceGenreParam', 'auth'));
    }
    public function showDeviceProduct(Router $router)
    {
        // ルートパラメータを取得
        $routeParams = $router->getCurrentRoute()->parameters();
        $deviceDomain = new DeviceDomain;
        // メインデバイス
        $device = $deviceDomain->getProductOfDevice($routeParams);
        $device->device_name = str_replace('_', ' ', $device->device_name);
        $device->maker_name = $device->getMaker->maker_name;
        // 関連デバイス(メーカー&ジャンル一致)
        $subDevices = $deviceDomain->getSubDevices($routeParams);
        foreach($subDevices as $subDevice)
        {
            $subDevice->device_name = str_replace('_', ' ', $subDevice->device_name);
        }
        $auth = $this->getAuthUser();
        
        return view('devices.product', compact('device', 'auth', 'subDevices'));
    }

    // 管理者用
    public function showDeviceAddPage()
    {
        if(Auth::user()->username === 'yasuha' || Auth::user()->username === 'finnegantz')
        {
            $auth = $this->getAuthUser();
            return view('devices.add', compact('auth'));
        }
        else
        {
            return redirect()->action('UserController@showUserList');
        }
    }
    public function addDevice(AddDeviceRequest $request)
    {
        if(Auth::user()->username === 'yasuha' || Auth::user()->username === 'finnegantz')
        {
            $deviceDomain = new DeviceDomain;
            $device = $deviceDomain->addNewDevice($request);
            $deviceDomain->save($device);
    
            return redirect()->action('DeviceController@showDeviceList');
        }
        else
        {
            return redirect()->action('UserController@showUserList');
        }
    }
    public function showDeviceEditPage(Router $router)
    {
        if(Auth::user()->username === 'yasuha' || Auth::user()->username === 'finnegantz')
        {
            $routeParams = $router->getCurrentRoute()->parameters();
            $deviceDomain = new DeviceDomain;
            $device = $deviceDomain->getProductOfDevice($routeParams);
            $device->maker_name = $device->getMaker->maker_name;
            $auth = $this->getAuthUser();
    
            return view('devices.edit', compact('device', 'auth'));
        }
        else
        {
            return redirect()->action('UserController@showUserList');
        }
    }
    public function editDevice(Router $router, EditDeviceRequest $request)
    {
        if(Auth::user()->username === 'yasuha' || Auth::user()->username === 'finnegantz')
        {
            $routeParams = $router->getCurrentRoute()->parameters();
            $deviceDomain = new DeviceDomain;
            $device = $deviceDomain->getProductOfDevice($routeParams);
            $device->device_name = $request->input('deviceName');
            $device->maker_id = Maker::where('maker_name', $request->input('makerName'))->first()->id;
            $deviceDomain->save($device);
    
            return redirect()->action('DeviceController@showDeviceList');
        }
        else
        {
            return redirect()->action('UserController@showUserList');
        }
    }
}
