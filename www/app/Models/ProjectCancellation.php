<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectCancellation extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'project_cancellations';
    protected $primaryKey= 'id';
    protected $fillable = [
        'project_id'
    ];
}