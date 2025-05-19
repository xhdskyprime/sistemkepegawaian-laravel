<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);  // paginate 10 data per halaman
        return view('employees.index', compact('employees'));
    }


    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diupdate');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus');
    }

    public function create()
    {
        return view('employees.create');  // pastikan kamu sudah punya file view ini
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    // public function sip()
    // {
    //     $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')->paginate(10);
    //     return view('sips.sip', compact('employees'));
    // }

    // public function sip(Request $request)
    // {
    //     $search = $request->input('search');

    //     $employees = Employee::where('jenis_pegawai', 'Tenaga Medis')
    //         ->when($search, function ($query, $search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('nama', 'like', "%{$search}%")
    //                     ->orWhere('nip', 'like', "%{$search}%")
    //                     ->orWhere('no_sip', 'like', "%{$search}%")
    //                     ->orWhere('email', 'like', "%{$search}%");
    //             });
    //         })
    //         ->paginate(10);

    //     return view('sips.sip', compact('employees', 'search'));
    // }



    public function sip(Request $request)
    {
        $query = Employee::where('jenis_pegawai', 'Tenaga Medis');

        // Filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->orWhere('no_sip', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter SIP yang akan expired dalam 6 bulan ke depan
        $sixMonthsFromNow = Carbon::now()->addMonths(6);
        $query->whereDate('tanggal_kadaluwarsa', '<=', $sixMonthsFromNow);

        $employees = $query->paginate(10);

        return view('sips.sip', compact('employees'));
    }
}
