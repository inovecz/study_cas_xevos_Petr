<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\Employeer;

class EmployeeEditService
{
    public function editEmployee(Employee $employee, array $employeeData): bool
    {
        $activeSalary = null;
        if ($employeeData['salary'] !== null) {
            $localEmployeer = Employeer::firstOrCreate(['name' => 'Vlastní']);
            $activeSalary = $employee->salaries()->updateOrCreate(['employee_id' => $employee->getRemoteId(), 'employeer_id' => $localEmployeer->getID()], ['salary' => $employeeData['salary']]);
        }
        $updated = $employee->update([
            'name' => $employeeData['name'],
            'surname' => $employeeData['surname'],
            'remote_date' => $employeeData['date'],
            'active_salary_id' => $activeSalary?->getId()
        ]);

        return $updated;
    }
}
