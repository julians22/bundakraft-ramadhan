<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecipeMoment extends Model
{
    use HasFactory, \Spatie\Tags\HasTags, \Spatie\Sluggable\HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug'];

    protected $with = [
        'recipes'
    ];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // /**
    //  * Get all of the recipes for the RecipeMoment
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function recipes(): HasMany
    // {
    //     return $this->hasMany(Recipe::class, 'recipe_moment_id', 'id');
    // }

    /**
     * Get all of the recipes for the RecipeMoment
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_has_moment' , 'recipe_moment_id', 'recipe_id');
    }
}
