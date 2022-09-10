<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Services\RemoteDataFetchService;
use Illuminate\Database\Eloquent\Builder;

class SalariesTable extends Component
{
    use WithPagination;

    public int $pageLength = 10;
    public string $search = '';
    public string $orderBy = 'surname';
    public bool $sortAsc = false;
    public bool $hideNoSalary = false;

    public array $filters = ['all' => 'Vše', 'name' => 'Jméno', 'surname' => 'Příjmení', 'salary' => 'Výplata', 'employeer' => 'Zaměstnavatel'];
    public string $filter = 'all';

    protected $queryString = ['filter', 'search', 'orderBy', 'sortAsc'];

    protected $listeners = [
        'refreshList' => '$refresh'
    ];

    public function render()
    {
        $employees = Employee::select('employees.*', 'salaries.id as salaryId', 'salaries.salary', 'employeers.id as employeerId', 'employeers.name as employeerName')
            ->leftJoin('salaries', 'salaries.id', 'employees.active_salary_id')
            ->leftJoin('employeers', 'employeers.id', 'salaries.employeer_id')
            ->when($this->hideNoSalary, function (Builder $query) {
                $query->whereNotNull('salaries.salary');
            })
            ->when($this->search !== '', function (Builder $query) {
                $query->when($this->filter === 'all', function(Builder $searchQuery) {
                    $searchQuery->where('employees.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('surname', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('salaries.salary', 'LIKE', '%' . Str::replace(' ', '', $this->search) . '%')
                        ->orWhere('employeers.name', 'LIKE', '%' . $this->search . '%');
                });
                $query->when($this->filter === 'name', function(Builder $searchQuery) {
                    $searchQuery->where('employees.name', 'LIKE', '%' . $this->search . '%');
                })->when($this->filter === 'surname', function(Builder $searchQuery) {
                    $searchQuery->where('surname', 'LIKE', '%' . $this->search . '%');
                })->when($this->filter === 'salary', function(Builder $searchQuery) {
                    $searchQuery->where('salaries.salary', 'LIKE', '%' . Str::replace(' ', '', $this->search) . '%');
                })->when($this->filter === 'employeer', function(Builder $searchQuery) {
                    $searchQuery->where('employeers.name', 'LIKE', '%' . $this->search . '%');
                });
            })->when($this->orderBy !== '', function (Builder $orderQuery) {
                $orderQuery->orderBy($this->orderBy, $this->sortAsc ? 'asc' : 'desc');
            })->paginate($this->pageLength);
        return view('livewire.salaries-table', [
            'employees' => $employees
        ]);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function orderBy($field): void
    {
        if ($field === $this->orderBy) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->orderBy = $field;
    }

    public function fetchRemote(): void
    {
        $service = new RemoteDataFetchService();
        $service->fetchEmployees();
        $service->fetchSalaries();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => "Vzdálená data byla úspěšně importována!"]);
    }
}
