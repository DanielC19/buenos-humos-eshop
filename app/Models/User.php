<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

/**
 * Author: Daniel Correa
 *
 * @property int $id
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $birthdate
 * @property UserRole $role
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'birthdate',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'birthdate' => ['required', 'date', Rule::date()->beforeOrEqual(today()->subYears(18))],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function getBirthdate(): string
    {
        return $this->attributes['birthdate'];
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function getFullName(): string
    {
        return $this->attributes['name'].' '.$this->attributes['lastname'];
    }

    public function getLastname(): string
    {
        return $this->attributes['lastname'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getPhone(): string
    {
        return $this->attributes['phone'];
    }

    public function getRole(): UserRole
    {
        return $this->attributes['role'];
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->attributes['birthdate'] = $birthdate;
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function setLastname(string $lastname): void
    {
        $this->attributes['lastname'] = $lastname;
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setPhone(string $phone): void
    {
        $this->attributes['phone'] = $phone;
    }

    public function setRole(UserRole $role): void
    {
        $this->attributes['role'] = $role;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'role' => UserRole::class,
            'password' => 'hashed',
        ];
    }
}
