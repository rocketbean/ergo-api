<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\Tag;
use App\Models\Location;
use App\Models\JobOrder;
use App\Models\Photo;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class Supplier extends Model
{

    /**
     * this guarded attributes cannot be mass assigned.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'client', 'remember_token',
    ];

    /**
     * automatically load relations upon call
     *
     * @var array
     */
    protected $with = [
        'primary'
    ];

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function owner () {
      return $this->belongsTo(User::class);
    }

    public function location () {
      return $this->belongsTo(Location::class);
    }

    /**
     * Get all the location tagged to supplier.
     */
     public function locations () {
      return $this->morphToMany(Location::class, 'locationable');
     }
     
    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


    /**
     * Get all of the [files] for the [property].
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    /**
     * Get all of the tags for the post.
     */
    public function joborders()
    {
        return $this->hasMany(JobOrder::class);
    }
    
    /**
     * Get all of the photos for the jobrequest.
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the [videos] for the [property].
     */
    public function videos()
    {
        return $this->morphToMany(Video::class, 'videoable');
    }

    /**
     * Get all of the [users] for the [supplier].
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('client_id');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists,  $using = null)
    {
        if ($parent instanceof User) {
            return SupplierUserPivot::fromRawAttributes($parent, $attributes, $table, $exists, $using);
        }

        return parent::newPivot($parent, $attributes, $table, $exists, $using);
    }

    /**
     * Get [primary] for the [supplier].
     */
    public function primary()
    {
        return $this->belongsTo(Photo::class, 'primary');
    }

    public static function AuthenticateRelations (User $user, Supplier $supplier) {
        $auth = false;
        $client = 0;
        foreach ($user->suppliers as $key) {
            if($supplier->id === $key->id ) {
                $client = $key->pivot->client_id;
                $auth = true;
            }
        }
        return ['guard' => $auth, 'client' => $client];
    }

    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(Supplier $supplier, $model, $relation)
    {
        if(!$supplier->{$relation}->contains($model['id']))
            $supplier->{$relation}()->attach($model['id']);
    }
}
