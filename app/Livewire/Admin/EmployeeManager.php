<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EmployeeManager extends Component
{
    public $employees = [];

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            return $this->redirect('/login', navigate: true);
        }

        $this->loadEmployees();
    }

    public function loadEmployees()
    {
        $this->employees = Employee::with(['user', 'department', 'attendances' => function($q) {
            $q->where('date', now()->toDateString());
        }])->get();
    }

    public function logAttendance(int $employeeId, string $status)
    {
        try {
            Attendance::updateOrCreate(
                ['employee_id' => $employeeId, 'date' => now()->toDateString()],
                ['status' => $status, 'check_in' => $status === 'Present' ? '09:00:00' : null]
            );

            $this->dispatch('toast', message: "Attendance recorded successfully!", type: 'success');
            $this->loadEmployees();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.employee-manager');
    }
}
