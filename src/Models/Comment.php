<?php

namespace Lnch\LaravelBlog\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const STATUS_PENDING_APPROVAL = 'P';
    const STATUS_APPROVED = 'A';
    const STATUS_REJECTED = 'R';
    const STATUS_SPAM = 'S';

    protected $table = "blog_comments";

    protected $fillable = [
        'post_id',
        'user_id',
        'name',
        'email',
        'body',
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected $dates = [
        'moderated_at',
        'created_at',
        'updated_at',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, "post_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, "moderated_by");
    }
}
