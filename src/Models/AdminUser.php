<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends User {
    use HasApiTokens, HasFactory, Notifiable;

}
