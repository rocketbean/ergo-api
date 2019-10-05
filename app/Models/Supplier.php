<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
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
        'primary',
        'reviews'
    ];

     public function authorizeJobOrder () {
        if($this->authorized('show_joborders')) {
            return $this->hasMany(JobOrder::class);
        } else {
            return $this->hasMany(JobOrder::class)->where('user_id', Auth::user()->id);
        }
     }

    /**
     * check if the bridge is authorized
     */
    public function authorized($rule, $user = false)
    {
        if(!$user) {
            $bridge = (new SupplierUser)->userBridge($this);
        } else {
            $bridge = (new SupplierUser)->bridge($user, $this);
        }
        if(isset($bridge->role)) {
            return $bridge->role->permissions->contains(Permission::slug($rule));
        }
         return false;
    }
    /**
     * check if the bridge is authorized
     */
    public function permits()
    {
        $bridge = (new SupplierUser)->userBridge($this);
        return $bridge->role->permissions;
    }

    /**
     * check if the bridge is authorized
     */
    public function role()
    {
        return (new SupplierUser)->userBridge($this);
    }

    /**
     * Get all of the [roles] for the [supplier].
     */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'roleable')->withTimestamps();
    }

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function owner () {
      return $this->belongsTo(User::class);
    }

    public function location () {
      return $this->belongsTo(Location::class);
    }

    public function reviews () {
      return $this->hasMany(Review::class);
    }

    /*
    * counts the review score
    */
    public function computescore () {

        $total       = 0;
        $respondents = $this->getNoRespondents();
        foreach ($this->getReviews() as $review) {
            $total += $review->score;
        }
        if($respondents > 0)
            $sum = $total / $respondents;
        else
            $sum = 0;
        $this->update([
            'ratings' => $sum
        ]);
    }

    public function getNoRespondents () {

        return count($this->reviews);
    }

    public function getReviews () {

        return $this->reviews;
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
     * Activity relations.
     */
    public function activity()
    {
        return $this->morphOne(Activity::class, 'loggable');
    }

    /**
     * Get all of the [photos] for the [property].
     */
    public function primaryPhoto()
    {
        return $this->belongsTo(Photo::class, 'primary');
    }

    /**
     * creates loggable acivity
     */
    public function logActivity(Array $data, $model)
    {
        $data['user_id'] = Auth::user()->id;
        $data['target_id'] = $model->id;
        $data['target_type'] = 'App\\Models\\' . class_basename($model);
        return $this->activity()->create($data);
    }

    /**
     * Get all of the [users] for the [supplier].
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('client_id');
    }

    /**
     * Get all of the [users] for the [supplier].
     */
    public function supplierUsers()
    {
        return $this->belongsToMany(User::class)
            ->using(SupplierUser::class)
            ->withPivot(['role_id', 'status'])
            ->as('supplierUsers');
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
