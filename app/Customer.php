<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ticket\Ticketit\Models\Ticket;  

class Customer extends Authenticatable 
{
    use Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * tickets created by this customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }
}