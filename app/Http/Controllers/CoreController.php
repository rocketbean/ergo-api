<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobRequest;
use App\Models\Supplier;
use App\Models\Property;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\Role;
use App\Models\Alert;
use App\Services\ErgoService;
use App\Services\SupplierNotification;
use App\Services\PropertyNotification;
use App\Services\NotificationService;
use App\Services\ActionModal;
use App\Services\ActionActive;
use App\Models\Country;
use App\Http\Resources\Country as CountryResource;
use Illuminate\Http\Request;


class CoreController extends Controller
{
    /**
     * Creates The first admin [user]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function configure() {
        $this->createFirstUser();
        $this->assignPhotos();
        $this->assignTags();
    }

    /**
     * Creates The first admin [user]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createFirstUser() {
        $user = ErgoService::GetUser();
        return User::create($user);
    }

    /**
     * Creates The first admin [user]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignPhotos() {
        return Photo::create([
          'user_id'  => 1,
          'filename' => 'default',
          'ext'      => 'jpg',
          'thumb'    => 'images/thumb/house.jpg',
          'path'     => 'images/house.jpg',
        ]);
    }

    /**
     * Creates The first admin [user]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countries() {
        return Country::all();
        // return new CountryResource($country);
    }

    /**
     * Creates The general services tags [options]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignTags() {
        $tags = (new Tag)->general_services();
        foreach ($tags as $tag) {
            Tag::create([
                'name'          => $tag['name'],
                'icon'          => $tag['icon'],
                'description'   => $tag['description']
            ]);
        }
        return Tag::all();
    }

    /**
     * Creates The general roles for users[options]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRoles() {
        $roles = (new Role)->open_roles();
        foreach ($roles as $role) {
            Role::create([
                'name'          => $role['name'],
                'type'          => $role['type'],
                'description'   => $role['description']
            ]);
        }
        return Role::all();
    }

    /**
     * returns Tag list
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tags() {
        return Tag::all();
    }

    public function testClass () {
        // return Alert::get();
    }
}
