<?php

namespace App\Models;
use Auth;
use App\Models\Photo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'suppliers',
        'primary'
    ];

    public static function validate(Request $request)
    {
        return $request->validate([
            'email'                 => 'required|string|email|max:255|unique:users',
            'name'                  => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class);
            // ->using(PropertyUser::class)
            // ->accessor("role");
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function propertyUsers()
    {
        return $this->belongsToMany(Property::class)
            ->using(PropertyUser::class)
            ->withPivot(['role_id', 'status'])
            ->as('propertyUsers');
    }
    // public function properties()
    // {
    //     return $this->hasMany(Property::class);
    // }

    /**
     * Activity relations.
     */
    public function activity()
    {
        return $this->morphOne(Activity::class, 'loggable');
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
     * Get all of the [photos] for the [user].
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the [videos] for the [user].
     */
    public function videos()
    {
        return $this->morphToMany(Video::class, 'videoable');
    }

    /**
     * Get all of the [photos] for the [user].
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('client_id');
    }


    /**
     * Get all of the [photos] for the [property].
     */
    public function primary()
    {
        return $this->belongsTo(Photo::class, 'primary');
    }


    
    /**
     * Get all of the [notifications] for the [user].
     */
    // public function notifications()
    // {
        // return $this->hasMany(Notification::class);
    // }


    public function newPivot(Model $parent, array $attributes, $table, $exists,  $using = null)
    {
        if ($parent instanceof User) {
            return SupplierUser::fromRawAttributes($parent, $attributes, $table, $exists, $using);
        }

        return parent::newPivot($parent, $attributes, $table, $exists, $using);
    }


    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(User $user, $model, $relation)
    {
        if(!$user->{$relation}->contains($model['id']))
            $user->{$relation}()->attach($model['id']);

    }

}
