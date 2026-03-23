<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
        'business_name',
        'gst_number',
        'contact_number',
        'referred_by',
        'loyalty_points',
        'last_login',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'loyalty_points' => 0,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'password' => 'hashed',
            // Stored as boolean in the DB (see add_is_admin_to_users_table migration)
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get orders for this user (customer).
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        // `role` is an enum added by migration; `is_admin` is a boolean flag.
        return $this->role === 'admin' || (bool) $this->is_admin;
    }

    /**
     * Check if user is a seller
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller' || $this->isAdmin();
    }

    /**
     * Check if user is a regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user' || !$this->role;
    }

    /**
     * Build a single-line or multi-line shipping address from stored fields.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);
        return implode(', ', $parts);
    }

    /**
     * Whether the user has any saved address.
     */
    public function hasSavedAddress(): bool
    {
        return !empty(trim($this->address_line_1 ?? ''));
    }
}
