<?php

namespace App;

use App\Application;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Bican\Roles\Models\Role;
use Bican\Roles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function listRoles()
    {
        $roles = $this->getRoles();
        if (!empty($roles)) {
            $role_names = $roles->pluck('name')->toArray();
            return comma_separate($role_names);
        }
    }

    public function assignRoleBySlug($slug)
    {
        $role = Role::where('slug', $slug)->first();
        $this->attachRole($role);

        return $this;
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class);
    }

    public function assignAppToUser(Application $app)
    {
        return $this->applications()->save($app);
    }

    public function assignedApps()
    {
        return $this->applications;
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

}
