<?php

namespace App\Http\Livewire\Modals;

use App\Models\Employee;
use LivewireUI\Modal\ModalComponent;
use App\Http\Livewire\SalariesTable;
use App\Services\EmployeeEditService;

class EditEmployee extends ModalComponent
{
    public Employee $employee;
    public string $name = '';
    public string $surname = '';
    public ?string $date = null;
    public $salary = null;

    protected $rules = [
        'name' => 'required|string|min:2',
        'surname' => 'required|string|min:2',
        'date' => 'nullable|date',
        'salary' => 'nullable|numeric'
    ];

    protected $messages = [
        'name.required' => 'Jméno musí být vyplněno',
        'name.min' => 'Jméno musí obsahovat alespoň 2 znaky',
        'surname.required' => 'Příjmení zaměstnance musí být vyplněno',
        'surname.min' => 'Příjmení musí obsahovat alespoň 2 znaky',
        'salary.numeric' => 'Vyplata musí být číselná hodnota',
    ];

    public function mount(int $employeeId)
    {
        $this->employee = Employee::find($employeeId);
        $this->name = $this->employee->getName();
        $this->surname = $this->employee->getSurname();
        $this->date = $this->employee->getRemoteDate()?->toDateString();
        $this->salary = $this->employee->activeSalary?->getSalary();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.modals.edit-employee');
    }

    public function submit(): void
    {
        if ($this->date === '') {
            $this->date = null;
        }
        if ($this->salary === '') {
            $this->salary = null;
        }
        $employeeData = $this->validate();
        $service = new EmployeeEditService();
        $response = $service->editEmployee($this->employee, $employeeData);
        if ($response) {
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => "Zaměstnanec {$this->employee->getFullName(true)} byl úspěšně upraven!"]);
            $this->closeModalWithEvents([
                SalariesTable::getName() => 'refreshList',
            ]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => "Zaměstnance {$this->employee->getFullName(true)} se nepodařilo upravit!"]);
        }
    }
}
