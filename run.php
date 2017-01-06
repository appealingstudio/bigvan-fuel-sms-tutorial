<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use Vinli\Client;

//Lets load everything up
$vinli = new Vinli\Client("***","***");
$devices = $vinli->getDevices();

//I only have one device
$myDevice = $devices[0];

//We just want the fuel level and RPMS
$fuelSnapshots = $myDevice->getSnapshots(['fuelLevelInput']);
$rpmSnapshots = $myDevice->getSnapshots(['rpm']);

//Lets just get the lastest snapshots
$fuelLevel = $fuelSnapshots[0]->data->fuelLevelInput;
$rpms = $rpmSnapshots[0]->data->rpm;

//Just so we know it's working
echo "Fuel Level Is " . $fuelLevel;
echo "\r\nRPM is " . $rpms;

//Ok, is the car running and is fuel low?
if($rpms > 100 and $fuelLevel < 15){
    //Send text message
    $client = new Twilio\Rest\Client("***", "***");

    //And off we go
    $client->account->messages->create(
        '1231234567',
        array(
            'from' => '1231234567',
            'body' => 'Hey there! Your running low.'
        )
    );
}
