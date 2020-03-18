<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    protected $goldFields = ['location'];
    protected $fillable = [
        'name', 'phone', 'location', 'user_id'
    ];

    /**
     * Mutator for set location
     * @param array $value
     */
    public function setLocationAttribute(array $value)
    {
        $this->attributes['location'] = DB::raw("POINT({$value[0]} ,{$value[1]})");
    }

    /**
     * Accessor for get location as "latitude,longitude"
     * @param $value
     * @return false|string
     */
    public function getLocationAttribute($value)
    {
        $loc = substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        return substr($loc, 0, -1);
    }

    /**
     * Add  ST_AsText function to new query builder for the location.
     * ST_AsText function in mysql 5.7.*
     * @return Builder
     */
    public function newQuery()
    {
        $raw = '';
        foreach ($this->goldFields as $column) {
            $raw .= ' ST_AsText(' . $column . ') as ' . $column . ' ';
        }
        return parent::newQuery()->addSelect('*', DB::raw($raw));
    }

    /**
     * Gives us the distance from a location point (in the form of a string "latitude,longitude"
     * ST_Distance_Sphere Returns the mimimum spherical distance between two points
     * ST_Distance_Sphere function in mysql 5.7.*
     * @param $query
     * @param $dist
     * @param $location
     * @return mixed
     */
    public function scopeDistance($query, $dist, $location)
    {
        return $query->whereRaw('ST_Distance_Sphere(location,POINT(' . $location . ')) < ' . $dist);
    }
    /**
     * Get the user record associated with the store.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the products for the store.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
