<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    /*
	* returns the [User]
    */
    public function respondent () {
    	return $this->belongsTo(User::class);
    }


    /*
	* returns the service [Supplier::class]
    */
    public function provider () {
    	return $this->belongsTo(Supplier::class);
    }




    /*
	* adds a row for reviewer
    */
    public static function addRespondent (User $user, Supplier $supplier) {
    	if(self::validateRespondent($user, $supplier)) {
    		Review::create([
    			'reviewer_id' => $user->id,
    			'supplier_id' => $supplier->id,
    		]);
    	}
    }

    /*
	* returns the service [Supplier::class]
    */
    public static function validateRespondent (User $user, Supplier $supplier) {
    	$valid = false;
    	$ex = Review::where('reviewer_id', $user->id)
    		->where('supplier_id', $supplier->id)
    		->exists();

    	if (!$ex) {
    		$valid = true;
    	}

    	return $valid;
    }

    /*
	* returns the service [Supplier::class]
    */
    public static function enableRespondent (User $user, Supplier $supplier) {
    	return Review::where('reviewer_id', $user->id)
    		->where('supplier_id', $supplier->id)
    		->where('content', null)
    		->where('score', null)
    		->exists();
    }
}
