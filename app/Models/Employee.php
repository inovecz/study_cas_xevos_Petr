<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Employee extends Model
{
    use BaseModel;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['remote_date'];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    public function employeers(): HasManyThrough
    {
        return $this->hasManyThrough(Employeer::class, Salary::class, 'employee_id', 'id', 'remote_id', 'employeer_id');
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class, 'employee_id', 'remote_id');
    }

    public function activeSalary(): HasOne
    {
        return $this->hasOne(Salary::class, 'id', 'active_salary_id');
    }

    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getRemoteId(): int
    {
        return $this->remote_id;
    }

    public function getRemoteDate(): ?Carbon
    {
        return $this->remote_date;
    }

    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    public function getName(bool $ascii = false): string
    {
        return $ascii ? Str::ascii($this->name) : $this->name;
    }

    public function getSurname(bool $ascii = false): string
    {
        return $ascii ? Str::ascii($this->surname) : $this->surname;
    }

    public function getFullName(bool $reverse = false, bool $ascii = false)
    {
        $fullname = collect([$this->getName($ascii), $this->getSurname($ascii)]);
        return $reverse ? $fullname->reverse()->implode(' ') : $fullname->implode(' ');
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">

}
