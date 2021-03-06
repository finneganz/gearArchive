<?php

namespace App\Domains;

use App\Models\Devices\Maker;
use App\Models\Devices\Headset;
use App\Models\Devices\Keyboard;
use App\Models\Devices\Mic;
use App\Models\Devices\Monitor;
use App\Models\Devices\Mouse;
use App\Models\Devices\Mousebungee;
use App\Models\Devices\Mousepad;

class DeviceDomain
{
    public function getSomeDevices()
    {
        $headsets = Headset::get();
        $keyboards = Keyboard::get();
        $mics = Mic::get();
        $monitors = Monitor::get();
        $mouses = Mouse::get();
        $mousebungees = Mousebungee::get();
        $mousepads = Mousepad::get();

        foreach($headsets as $headset)
        {
            $headset->device_name = str_replace('_', ' ', $headset->device_name);
            $headset->maker_name = $headset->getMaker->maker_name;
            $headset->maker_name = str_replace('_', ' ', $headset->maker_name);
            $headset->genre = 'headsets';
        }
        foreach($keyboards as $keyboard)
        {
            $keyboard->device_name = str_replace('_', ' ', $keyboard->device_name);
            $keyboard->maker_name = $keyboard->getMaker->maker_name;
            $keyboard->maker_name = str_replace('_', ' ', $keyboard->maker_name);
            $keyboard->genre = 'keyboards';
        }
        foreach($mics as $mic)
        {
            $mic->device_name = str_replace('_', ' ', $mic->device_name);
            $mic->maker_name = $mic->getMaker->maker_name;
            $mic->maker_name = str_replace('_', ' ', $mic->maker_name);
            $mic->genre = 'mics';
        }
        foreach($monitors as $monitor)
        {
            $monitor->device_name = str_replace('_', ' ', $monitor->device_name);
            $monitor->maker_name = $monitor->getMaker->maker_name;
            $monitor->maker_name = str_replace('_', ' ', $monitor->maker_name);
            $monitor->genre = 'monitors';
        }
        foreach($mouses as $mouse)
        {
            $mouse->device_name = str_replace('_', ' ', $mouse->device_name);
            $mouse->maker_name = $mouse->getMaker->maker_name;
            $mouse->maker_name = str_replace('_', ' ', $mouse->maker_name);
            $mouse->genre = 'mouses';
        }
        foreach($mousebungees as $mousebungee)
        {
            $mousebungee->device_name = str_replace('_', ' ', $mousebungee->device_name);
            $mousebungee->maker_name = $mousebungee->getMaker->maker_name;
            $mousebungee->maker_name = str_replace('_', ' ', $mousebungee->maker_name);
            $mousebungee->genre = 'mousebungees';
        }
        foreach($mousepads as $mousepad)
        {
            $mousepad->device_name = str_replace('_', ' ', $mousepad->device_name);
            $mousepad->maker_name = $mousepad->getMaker->maker_name;
            $mousepad->maker_name = str_replace('_', ' ', $mousepad->maker_name);
            $mousepad->genre = 'mousepads';
        }
        $devices = [
            'headset' => $headsets,
            'keyboard' => $keyboards,
            'mic' => $mics,
            'monitor' => $monitors,
            'mouse' => $mouses,
            'mousebungee' => $mousebungees,
            'mousepad' => $mousepads,
        ];

        return $devices;
    }
    public function getDeviceOfGenre(string $deviceGenreParam)
    {
        switch ($deviceGenreParam) {
            case 'headsets':
                $devices = Headset::inRandomOrder()->take(100)->get();
                break;
            case 'keyboards':
                $devices = Keyboard::inRandomOrder()->take(100)->get();
                break;
            case 'mics':
                $devices = Mic::inRandomOrder()->take(100)->get();
                break;
            case 'monitors':
                $devices = Monitor::inRandomOrder()->take(100)->get();
                break;
            case 'mouses':
                $devices = Mouse::inRandomOrder()->take(100)->get();
                break;
            case 'mousebungees':
                $devices = Mousebungee::inRandomOrder()->take(100)->get();
                break;
            case 'mousepads':
                $devices = Mousepad::inRandomOrder()->take(100)->get();
                break;
            default:
                //
                break;
        }
        foreach($devices as $device)
        {
            $device->device_name = str_replace('_', ' ', $device->device_name);
            $device->maker_name = $device->getMaker->maker_name;
        }
        return $devices;
    }
    public function getProductOfDevice(array $routeParams)
    {
        $deviceParam = $routeParams['device'];
        $makerParam = $routeParams['maker'];
        $productParam = $routeParams['product'];

        $makerId = Maker::where('maker_name', $makerParam)->first()->id;
        switch ($deviceParam) {
            case 'headsets':
                $device = Headset::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'keyboards':
                $device = Keyboard::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'mics':
                $device = Mic::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'monitors':
                $device = Monitor::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'mouses':
                $device = Mouse::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'mousebungees':
                $device = Mousebungee::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            case 'mousepads':
                $device = Mousepad::where('device_name', $productParam)->where('maker_id', $makerId)->first();
                break;
            default:
                //
                break;
        }
        return $device;
    }
    public function getSubDevices(array $routeParams)
    {
        $genreParam = $routeParams['device'];
        $makerParam = $routeParams['maker'];
        $makerId = Maker::where('maker_name', $makerParam)->first()->id;

        switch ($genreParam) {
            case 'headsets':
                $subDevices = Headset::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'keyboards':
            $subDevices = Keyboard::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'mics':
            $subDevices = Mic::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'monitors':
            $subDevices = Monitor::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'mouses':
            $subDevices = Mouse::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'mousebungees':
            $subDevices = Mousebungee::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            case 'mousepads':
            $subDevices = Mousepad::where('maker_id', $makerId)->inRandomOrder()->take(10)->get();
                break;
            default:
                //
                break;
        }
        return $subDevices;
    }
    public function addNewDevice(object $request)
    {
        switch ($request->deviceType) {
            case 'headset':
                $device = new Headset;
                break;
            case 'keyboard':
                $device = new Keyboard;
                break;
            case 'mic':
                $device = new Mic;
                break;
            case 'monitor':
                $device = new Monitor;
                break;
            case 'mouse':
                $device = new Mouse;
                break;
            case 'mousebungee':
                $device = new Mousebungee;
                break;
            case 'mousepad':
                $device = new Mousepad;
                break;
            default:
                //
                break;
        }
        $device->device_name = $request->input('deviceName');
        $device->maker_id = Maker::where('maker_name', $request->makerName)->first()->id;
        
        return $device;
    }
    public function save(object $modelInstance)
    {
        $modelInstance->save();
    }
}
