<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRolesAndAbilities;

    use Searchable, Filterable;

    use InteractsWithMedia;

    /**
     * ALlowed search fields
     * @var string[]
     */
    protected $searchFields = ['username', 'email'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
        'avatar_thumb_url',
        'full_name',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * @return \Closure|mixed|null|Media
     */
    public function avatar()
    {
        return $this->getMedia('avatars')->first();
    }

    /**
     * Returns the avatar url attribute
     * @return string|null
     */
    public function getAvatarUrlAttribute()
    {
        $avatar = $this->avatar();
        if ($avatar) {
            return $avatar->getFullUrl();
        }

        return null;
    }

    /**
     * Returns the avatar url attribute
     * @return string|null
     */
    public function getAvatarThumbUrlAttribute()
    {
        $avatar = $this->avatar();
        if ($avatar) {
            return $avatar->getAvailableFullUrl(['small_thumb']);
        }

        return null;
    }

    /**
     * Returns the full_name attribute
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->username;
    }

    /**
     * Returns the is_admin attribute
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->isAn('admin');
    }

    /**
     * Register the conversions
     *
     * @param  Media|null  $media
     *
     * @return void
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small_thumb')
             ->fit(Manipulations::FIT_CROP, 300, 300)
             ->nonQueued();
        $this->addMediaConversion('medium_thumb')
             ->fit(Manipulations::FIT_CROP, 600, 600)
             ->nonQueued();
        $this->addMediaConversion('large_thumb')
             ->fit(Manipulations::FIT_CROP, 1200, 1200)
             ->nonQueued();
    }
}
