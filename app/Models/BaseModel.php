<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Scopes\AccountScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new AccountScope());

        static::creating(function (Model $model): void {
            if (Auth::check()) {
                $model->account_id = Auth::user()->account_id;
            }
        });
    }
}
