<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property ProductReview[] $productReviews
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'birthdate',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'role' => UserRole::class,
            'password' => 'hashed',
        ];
    }

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

    // setters & getters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getLastname(): string
    {
        return $this->attributes['lastname'];
    }

    public function setLastname(string $lastname): void
    {
        $this->attributes['lastname'] = $lastname;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getPhone(): string
    {
        return $this->attributes['phone'];
    }

    public function setPhone(string $phone): void
    {
        $this->attributes['phone'] = $phone;
    }

    public function getBirthdate(): string
    {
        return $this->attributes['birthdate'];
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->attributes['birthdate'] = $birthdate;
    }

    public function getRole(): UserRole
    {
        return $this->attributes['role'];
    }

    public function setRole(UserRole $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function getProductReviews(): Collection
    {
        return ProductReview::where('user_id', $this->getId())->get();
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at']) : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->attributes['updated_at'] ? Carbon::parse($this->attributes['updated_at']) : null;
    }

    // utils

    public function isAdmin(): bool
    {
        return $this->attributes['role'] === UserRole::ADMIN;
    }

    public function getFullName(): string
    {
        return $this->attributes['name'].' '.$this->attributes['lastname'];
    }

    public static function customers()
    {
        return self::where('role', '!=', UserRole::ADMIN);
    }

    // relationships

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}
