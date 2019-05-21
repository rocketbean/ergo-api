<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\JobRequest;
use App\Models\Supplier;
class Tag extends Model
{
    protected $guarded = [];

    /**
     * Get all of the posts that are assigned this tag  [Property].
     */
    public function properties()
    {
        return $this->morphedByMany(Property::class, 'taggable');
    }

    /**
     * Get all of the posts that are assigned this tag [JobRequest].
     */
    public function jobrequests()
    {
        return $this->morphedByMany(JobRequest::class, 'taggable');
    }

    /**
     * Get all of the posts that are assigned this tag [Supplier].
     */
    public function suppliers()
    {
        return $this->morphedByMany(Supplier::class, 'taggable');
    }

    public function toArray() {
      return [
        'value' => $this->id,
        'label' => $this->name,
        'description' => $this->description,
        'icon' => $this->icon
      ];
    }

    /**
     * Get all of the posts that are assigned this tag [Supplier].
     */
    public function general_services()
    {
        return [
            [
                'name' => 'Plumbing',
                'description' => 'Plumbing / Piping Services',
                'icon' => 'fas fa-shower'
            ],
            [
                'name' => 'Construction',
                'description' => 'Construction / Building Services',
                'icon' => 'fas fa-hard-hat'
            ],
            [
                'name' => 'Paint',
                'description' => 'Paint Services',
                'icon' => 'fas fa-paint-roller'
            ],
            [
                'name' => 'Carpentry',
                'description' => 'Internal fixing services',
                'icon' => 'fas fa-hammer'
            ],
            [
                'name' => 'Car',
                'description' => 'Mechanic services',
                'icon' => 'fas fa-car-crash'
            ],
            [
                'name' => 'Electric',
                'description' => 'Electric services',
                'icon' => 'fas fa-plug'
            ],
            [
                'name' => 'Internal Designs',
                'description' => 'Design Services',
                'icon' => 'fas fa-pencil-ruler'
            ],
            [
                'name' => 'Exterior',
                'description' => 'Exterior Design Services',
                'icon' => 'fas fa-drafting-compass'
            ],
            [
                'name' => 'Gardening',
                'description' => 'Exterior Maintenance Services',
                'icon' => 'fas fa-seedling'
            ],
            [
                'name' => 'Security',
                'description' => 'Locks and Security Services',
                'icon' => 'fas fa-lock'
            ],
            [
                'name' => 'Connectivity',
                'description' => 'Network Services',
                'icon' => 'fas fa-wifi'
            ],

        ];
    }
}
