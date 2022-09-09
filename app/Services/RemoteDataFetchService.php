<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Employeer;

class RemoteDataFetchService
{
    protected const EMPLOYEES_URL = 'https://xevos.store/domaci-ukol/Jmena.json';
    protected const EMPLOYEER_URLS = [
        'Zamestnavatel1' => 'https://xevos.store/domaci-ukol/Zamestnavatel1.json',
        'Zamestnavatel2' => 'https://xevos.store/domaci-ukol/Zamestnavatel2.json',
        'Zamestnavatel3' => 'https://xevos.store/domaci-ukol/Zamestnavatel3.json',
    ];

    /** @return int count of fetched employees
     * @throws \JsonException
     */
    public function fetchEmployees(): int
    {
        $employees = $this->sendRequest(self::EMPLOYEES_URL);
        $employees = collect($employees)->map(static fn($employee) => ['remote_id' => $employee['id'], 'name' => $employee['jmeno'], 'surname' => $employee['prijmeni'], 'remote_date' => Carbon::parse($employee['date'])]);

        \DB::beginTransaction();
        foreach ($employees as $employee) {
            if (Employee::where('remote_id', $employee['remote_id'])->exists()) {
                Employee::where('remote_id', $employee['remote_id'])->update($employee);
            } else {
                Employee::create($employee);
            }
        }
        \DB::commit();
        return count($employees);
    }

    public function fetchSalaries(): void
    {
        $localEmployeer = Employeer::firstOrCreate(['name' => 'Vlastní']);
        Salary::where('employeer_id', '!=', $localEmployeer->getId())->delete();
        foreach (self::EMPLOYEER_URLS as $employeerName => $employeerUrl) {
            $employeer = Employeer::firstOrCreate(['name' => $employeerName]);
            $salaries = $this->sendRequest($employeerUrl);
            collect($salaries)->map(static fn($salary) => ['name' => $salary['jmeno'], 'surname' => $salary['prijmeni'], 'salary' => $salary['plat']])
                ->each(static function ($salary) use ($employeer, $localEmployeer) {
                    $employee = Employee::where('name', $salary['name'])->where('surname', $salary['surname'])->first();
                    if ($employee) {
                        $salary = $employee->salaries()->updateOrCreate(['employee_id' => $employee->getRemoteId(), 'employeer_id' => $employeer->getID()], ['salary' => $salary['salary']]);
                        $activeSalary = $employee->activeSalary;
                        if (!$activeSalary || ((float)$salary['salary'] >= $activeSalary->getSalary() && $activeSalary->employeer->getId() !== $localEmployeer->getId())) {
                            $employee->update(['active_salary_id' => $salary->getId()]);
                        }
                    }
                });
        }
    }

    /** @return array fetched, decoded data
     * @throws \JsonException
     */
    public function sendRequest(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}
