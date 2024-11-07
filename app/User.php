<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'ticketit_admin', 'ticketit_agent'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ticketit_admin' => 'boolean',
        'ticketit_agent' => 'boolean'
    ];

    public static function getRoles(){
        return[
            'admin' => 'Administrator',
            'agent' => 'Support Agent',
            'user' => 'Regular User'
        ];
    }

    public function isAdmin()
    {
        return $this->ticketit_admin;
    }

    public function isAgent()
    {
        return $this->ticketit_agent;
    }

    public function canManageTickets()
    {
        return $this->isAdmin() || $this->isAgent();
    }

    public function assignedTickets()
    {
        return $this->hasMany('Ticket\Ticketit\Models\Ticket', 'agent_id');
    }

    public function getAssignableTicketsQuery()
    {
        $query = \Ticket\Ticketit\Models\Ticket::query();
        
        if ($this->isAdmin()) {
            return $query; // Admin can see all tickets
        }
        
        if ($this->isAgent()) {
            return $query->where(function($q) {
                $q->where('agent_id', $this->id)
                  ->orWhereNull('agent_id'); // Agents can see their tickets and unassigned ones
            });
        }
        
        return $query->where('agent_id', $this->id); // Regular users see nothing
    }

    public function getAccessibleTickets()
    {
        if ($this->isAdmin()) {
            return \Ticket\Ticketit\Models\Ticket::with(['customer', 'status', 'priority']);
        }
        
        if ($this->isAgent()) {
            return \Ticket\Ticketit\Models\Ticket::with(['customer', 'status', 'priority'])
                ->where('agent_id', $this->id);
        }
        
        return collect([]); // Regular users see no tickets
    }

    public function scopeAgents($query)
    {
        return $query->where('ticketit_agent', true);
    }

    

    public function scopeAdmins($query)
    {
        return $query->where('ticketit_admin', true);
    }
}