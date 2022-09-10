<div class="container mx-auto">
    <div class="py-8">
        <h2 class="mb-4">Zaměstnanci</h2>

        <!--<editor-fold desc="SEARCH">-->
        <div class="flex min-w-full justify-between">
            <select wire:model="filter" id="filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5">
                @foreach ($filters as $filterKey => $filterLabel)
                <option value="{{ $filterKey }}">{{ $filterLabel }}</option>
                @endforeach
            </select>
            <div class="flex-1 mr-4">
                <input wire:model="search" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Vyhledat...">
            </div>
            <div>
                <button wire:click="fetchRemote" wire:loading.remove wire:target="fetchRemote" type="button" class="btn btn-primary">
                    <i class="fa-solid fa-arrows-rotate"></i><span class="d-none d-sm-inline ml-2">Načíst vzdálené</span>
                </button>
                <button wire:loading wire:target="fetchRemote" type="button" class="btn btn-primary" disabled>
                    <i class="fa-solid fa-arrows-rotate fa-spin"></i><span class="d-none d-sm-inline ml-2">Načíst vzdálené</span>
                </button>
            </div>
        </div>
        <div class="flex justify-between items-end mt-2">
            <div>
                <label class="flex items-center mr-2">
                    <input type="checkbox" wire:model="hideNoSalary" class="checkbox" checked="">
                    <span class="ml-2">Schovat zaměstnance bez výplaty</span>
                </label>
            </div>
        </div>
        <!--</editor-fold desc="SEARCH">-->

        <div class="pt-4 px-2 -mx-2 overflow-x-auto">
            <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('surname')">
                                    Příjmení
                                    <x-sort-icon field="surname" :orderBy="$orderBy" :sortAsc="$sortAsc" />
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('name')">
                                    Jméno
                                    <x-sort-icon field="name" :orderBy="$orderBy" :sortAsc="$sortAsc" />
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('remote_date')">
                                    Datum
                                    <x-sort-icon field="remote_date" :orderBy="$orderBy" :sortAsc="$sortAsc" />
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('salariesSalary')">
                                    Výplata
                                    <x-sort-icon field="salariesSalary" :orderBy="$orderBy" :sortAsc="$sortAsc" />
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('employeersName')">
                                    Zaměstnavatel
                                    <x-sort-icon field="employeersName" :orderBy="$orderBy" :sortAsc="$sortAsc" />
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-gray-700">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-200/50">
                                <td class="p-5 border-b border-gray-200 text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="{{ Avatar::create($employee->getFullName(true, true))->toBase64() }}" alt=""/>
                                        </div>
                                        <div class="ml-3 flex flex-col">
                                            <p class="text-lg text-gray-900 whitespace-no-wrap">{{ $employee->getSurname() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-lg text-gray-900 whitespace-no-wrap">{{ $employee->getName() }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-lg text-gray-900 whitespace-no-wrap">{{ $employee->getRemoteDate() ? $employee->getRemoteDate()->format('d.m.Y') : '-' }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-lg text-gray-900 whitespace-no-wrap">{{ $employee->salariesSalary ? format_price($employee->salariesSalary, 0) : '-' }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <p class="text-lg text-gray-900 whitespace-no-wrap">{{ $employee->employeersName ?? '-' }}</p>
                                </td>

                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-right">
                                    <div class="flex space-x-4 justify-end">
                                        <a wire:click.prevent='$emit("openModal", "modals.edit-employee", {{ json_encode(["employeeId" => $employee->getId()]) }})' class="btn btn-link p-0" title="Upravit zaměstnance">
                                            <i class="fa-solid fa-pen-to-square text-lg text-blue-500 hover:text-blue-700 curs"></i>
                                        </a>
                                        <a wire:click.prevent='$emit("openModal", "modals.delete-employee", {{ json_encode(["employeeId" => $employee->getId()]) }})' class="btn btn-link p-0" title="Odstranit zaměstnance">
                                            <i class="fa-solid fa-trash-alt text-lg text-red-500 hover:text-red-700"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="p-5">
                                    <div class="flex w-full justify-center">Nenalezena žádná data</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="inline-block min-w-full mt-4">
            {{ $employees->links() }}
        </div>
    </div>
</div>
