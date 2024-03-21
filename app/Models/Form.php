<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'forms';

    protected $fillable = [
        'workspace_id',
        'creator_id',
        'properties',
        'removed_properties',
        'notifies',
        'notification_emails',
        'send_submission_confirmation',
        'notification_sender',
        'notification_subject',
        'notification_body',
        'notifications_include_submission',
        'slack_webhook_url',
        'discord_webhook_url',
        'webhook_url',
        'title',
        'description',
        'tags',
        'visibility',
        'theme',
        'width',
        'cover_picture',
        'logo_picture',
        'dark_mode',
        'color',
        'uppercase_labels',
        'no_branding',
        'hide_title',
        'transparent_background',
        'custom_code',
        'submit_button_text',
        'database_fields_update',
        're_fillable',
        're_fill_button_text',
        'submitted_text',
        'redirect_url',
        'use_captcha',
        'closes_at',
        'closed_text',
        'max_submissions_count',
        'max_submissions_reached_text',
        'editable_submissions',
        'can_be_indexed',
        'password'
    ];

    protected $casts = [
        'properties' => 'array',
        'database_fields_update' => 'array',
        'closes_at' => 'datetime',
        'tags' => 'array',
        'removed_properties' => 'array'
    ];

    protected $hidden = [
        'workspace_id',
        'notifies',
        'slack_webhook_url',
        'discord_webhook_url',
        'webhook_url',
        'send_submission_confirmation',
        'redirect_url',
        'database_fields_update',
        'notification_sender',
        'notification_subject',
        'notification_body',
        'notifications_include_submission',
        'password',
        'tags',
        'notification_emails',
        'removed_properties'
    ];

    /**
     * Relationships
     */
    public function formSubmissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function score()
    {
        return $this->hasOne(Score::class);
    }

    /**
     * Config
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->doNotGenerateSlugsOnUpdate()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
