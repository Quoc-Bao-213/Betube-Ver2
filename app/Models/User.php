<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasMediaTrait;
    
    use SoftDeletes;

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function toggleVote($entity, $type)
    {
        $vote = $entity->votes->where('user_id', $this->id)->first();

        if ($vote) {
            $vote->update([
                'type' => $type
            ]);

            return $vote->refresh();
        } else {
            return $entity->votes()->create([
                'type' => $type,
                'user_id' => $this->id
            ]);
        }
    }

    public function editable()
    {
        if (!auth()->check())
            return false;

        return $this->id === auth()->user()->id;
    }

    public function avatar()
    {
        if ($this->media->where('collection_name', '=', 'images')->first()) {
            return $this->media->where('collection_name', '=', 'images')->first()->getFullUrl('avatar');
        }

        return "https://i.picsum.photos/id/890/200/200.jpg?hmac=_chNVuEZW4X8X4PEIIJNyv3kMTFOR517hu8zLfMAf70";
    }

    public function cover()
    {
        if ($this->media->where('collection_name', '=', 'covers')->first()) {
            return $this->media->where('collection_name', '=', 'covers')->first()->getFullUrl('cover');
        }

        return null;
    }

    public function registerMediaConversions(?Media $media = null)
    {
        $this->addMediaConversion('avatar')
            ->quality(80)
            ->nonQueued();

        $this->addMediaConversion('cover')
            ->quality(80)
            ->nonQueued();
    }

    //implement the attribute
    public function getAvatarAttribute()
    {
        return $this->avatar();
    }
}
