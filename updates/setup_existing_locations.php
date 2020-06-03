<?php namespace AlbrightLabs\ClientLocations\Updates;

use Seeder;
use AlbrightLabs\Client\Models\Client;
use AlbrightLabs\ClientLocations\Models\Location;

class SetupExistingLocations extends Seeder
{
    public function run()
    {
        $clients = Client::all();
        foreach($clients as $client){
            if(null != $client->street || null != $client->city || null != $client->state || null != $client->zip){
                $location = new Location;
                if(null != $client->street){
                    $location->street = $client->street;
                }
                if(null != $client->city){
                    $location->city = $client->city;
                }
                if(null != $client->state){
                    $location->state = $client->state;
                }
                if(null != $client->zip){
                    $location->zip = $client->zip;
                }
                $location->client_id = $client->id;
                $location->is_default = 1;
                $location->save();
            }
        }
    }
}
