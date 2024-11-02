<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ticket\Ticketit\Models\Ticket;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // boolean casts for ticketit columns
        'ticketit_admin' => 'boolean',
        'ticketit_agent' => 'boolean'
    ];

    /**
     * Check if user is a ticketit admin
     */
    public function isAdmin()
    {
        return (bool) $this->ticketit_admin;
    }

    /**
     * Check if user is a ticketit agent
     */
    public function isAgent()
    {
        return (bool) $this->ticketit_agent;
    }

    /**
     * Get tickets assigned to this user as agent
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'agent_id');
    }

    /**
     * Get tickets created by this user
     */
    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }
}