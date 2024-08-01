<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recipe extends Model implements HasMedia
{
    use HasFactory, \Spatie\Tags\HasTags, \Spatie\Sluggable\HasSlug, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'video_url',
        'ingredients',
        'instruction',
        'status',
        'sort',
        'moment',
        'recipe_moment_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'ingredients' => 'array',
        'instruction' => 'array',
        'video_url' => 'array'
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

    /**
     * Get the moment associated with the Recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function moment(): HasOne
    {
        return $this->hasOne(RecipeMoment::class, 'id', 'recipe_moment_id');
    }

    /**
     * Get moment associated with the Recipe (Without recipe)
     */
    public function moment_simple(): HasOne
    {
        return $this->hasOne(RecipeMoment::class, 'id', 'recipe_moment_id')
            ->without('recipes');
    }


    /**
     * The moments that belong to the Recipe
     */
    public function moments(): BelongsToMany
    {
        return $this->belongsToMany(RecipeMoment::class, 'recipe_has_moment', 'recipe_id', 'recipe_moment_id');
    }
}
