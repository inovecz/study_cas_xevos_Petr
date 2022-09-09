<?php

namespace App\Http\Livewire\Modals;

use App\Models\Employee;
use App\Http\Livewire\SalariesTable;
use LivewireUI\Modal\ModalComponent;

class DeleteEmployee extends ModalComponent
{
    public Employee $employee;

    public function mount(string $employeeId)
    {
        $this->employee = Employee::find($employeeId);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function render()
    {
        return view('livewire.modals.delete-employee');
    }

    public function confirm(): void
    {
        $name = $this->employee->getFullName(true);
        $this->employee->salaries()->delete();
        $this->employee->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => "Zaměstnanec $name byl úspěšně odstraněn!"]);
        $this->closeModalWithEvents([
            SalariesTable::getName() => 'refreshList',
        ]);
    }
}
