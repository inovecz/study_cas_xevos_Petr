<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $remote_id
 * @property string $name
 * @property string $surname
 * @property \Illuminate\Support\Carbon|null $remote_date
 * @property int|null $active_salary_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary|null $activeSalary
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employeer[] $employeers
 * @property-read int|null $employeers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary[] $salaries
 * @property-read int|null $salaries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereActiveSalaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRemoteDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employeer
 *
 * @method static firstOrCreate(string[] $array)
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employeer whereUpdatedAt($value)
 */
	class Employeer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Salary
 *
 * @property int $id
 * @property int $employee_id
 * @property int $employeer_id
 * @property float $salary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Employeer $employeer
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereEmployeerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereUpdatedAt($value)
 */
	class Salary extends \Eloquent {}
}

