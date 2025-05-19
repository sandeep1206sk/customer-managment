<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'contact_number', 'address', 'work_details', 'total_amount', 'due_amount'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

