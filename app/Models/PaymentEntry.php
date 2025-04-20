<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentEntry extends Model
{
    use HasFactory;
    protected $table = 'payment_entries';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNotebook()
    {
        return $this->belongsTo(Notebook::class, 'notebook_id', 'id');
    }
}
