<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
   public function index(Request $request)
   {
       $search = $request->search;

       $attendances = Attendance::with('student')
           ->when($search, function ($query) use ($search) {
               $query->whereHas('student', function ($q) use ($search) {
                   $q->where('name', 'like', '%' . $search . '%');
               });
           })
           ->latest()
           ->paginate(5)
           ->withQueryString();

       $jumlahHadir = Attendance::where('status', 'hadir')->count();
       $jumlahIzin = Attendance::where('status', 'izin')->count();
       $jumlahSakit = Attendance::where('status', 'sakit')->count();

       return view('attendance.index', compact(
           'attendances',
           'search',
           'jumlahHadir',
           'jumlahIzin',
           'jumlahSakit'
       ));
   }

   public function create()
   {
       $students = Student::orderBy('name')->get();

       return view('attendance.create', compact('students'));
   }

   public function store(Request $request)
   {
       $request->validate([
           'student_id' => [
               'required',
               'exists:students,id',
               Rule::unique('attendances')->where(function ($query) use ($request) {
                   return $query
                       ->where('student_id', $request->student_id)
                       ->where('date', $request->date);
               }),
           ],
           'date' => 'required|date',
           'status' => 'required|in:hadir,izin,sakit',
       ], [
           'student_id.required' => 'Nama siswa wajib dipilih.',
           'student_id.exists' => 'Data siswa tidak valid.',
           'student_id.unique' => 'Siswa sudah absen pada tanggal tersebut.',
           'date.required' => 'Tanggal wajib diisi.',
           'status.required' => 'Status wajib dipilih.',
       ]);

       Attendance::create([
           'student_id' => $request->student_id,
           'date' => $request->date,
           'status' => $request->status,
       ]);

       return redirect('/attendance')->with('success', 'Data absensi berhasil disimpan.');
   }

   public function edit($id)
   {
       $attendance = Attendance::findOrFail($id);
       $students = Student::orderBy('name')->get();

       return view('attendance.edit', compact('attendance', 'students'));
   }

   public function update(Request $request, $id)
   {
       $attendance = Attendance::findOrFail($id);

       $request->validate([
           'student_id' => [
               'required',
               'exists:students,id',
               Rule::unique('attendances')->where(function ($query) use ($request) {
                   return $query
                       ->where('student_id', $request->student_id)
                       ->where('date', $request->date);
               })->ignore($attendance->id),
           ],
           'date' => 'required|date',
           'status' => 'required|in:hadir,izin,sakit',
       ], [
           'student_id.unique' => 'Siswa sudah absen pada tanggal tersebut.',
       ]);

       $attendance->update([
           'student_id' => $request->student_id,
           'date' => $request->date,
           'status' => $request->status,
       ]);

       return redirect('/attendance')->with('success', 'Data absensi berhasil diperbarui.');
   }

   public function destroy($id)
   {
       $attendance = Attendance::findOrFail($id);
       $attendance->delete();

       return redirect('/attendance')->with('success', 'Data absensi berhasil dihapus.');
   }
}
