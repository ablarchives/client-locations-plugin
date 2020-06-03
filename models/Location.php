<?php namespace AlbrightLabs\ClientLocations\Models;

use Model;
use Bc\Clients\Models\Client;

/**
 * Location Model
 */
class Location extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'albrightlabs_clientlocations_locations';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'street', 'city', 'state', 'zip', 'is_default'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
      'title'  => 'between:2,255',
      'street' => 'required|between:2,255',
      'city'   => 'required|between:2,255',
      'state'  => 'required|between:2,255',
      'zip'    => 'required|digits:5',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'estimates' => 'Bc\Pay\Models\Estimate',
        'invoices' => 'Bc\Pay\Models\Invoice',
        'bookings' => 'AlbrightLabs\Book\Models\Booking',
    ];
    public $belongsTo = [
        'client' => 'Bc\Clients\Models\Client',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * Set default if needed
     */
    public function afterSave()
    {
        // if($this->is_default && $client = Client::find($this->client_id))){
        //     foreach($client->locations as $location){
        //         $location->is_default = 0;
        //         $location->save();
        //     }
        // }
    }
}
