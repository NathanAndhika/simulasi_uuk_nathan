<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Form Absensi Siswa
       </h2>
   </x-slot>

   <div class="py-8">
       <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white p-6 rounded shadow">

               <a href="{{ route('attendance.index') }}" class="text-blue-600">
                   Kembali
               </a>

               @if($errors->any())
                   <div class="my-4 p-4 bg-red-100 text-red-800 rounded">
                       <ul>
                           @foreach($errors->all() as $error)
                               <li>{{ $error }}</li>
                           @endforeach
                       </ul>
                   </div>
               @endif

               <form action="{{ route('attendance.store') }}" method="POST" class="mt-4">
                   @csrf

                   <div class="mb-4">
                       <label class="block mb-1">Nama Siswa</label>
                       <select name="student_id" class="w-full border rounded px-3 py-2">
                           <option value="">-- Pilih Siswa --</option>
                           @foreach($students as $student)
                               <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                   {{ $student->name }} - {{ $student->class }}
                               </option>
                           @endforeach
                       </select>
                   </div>

                   <div class="mb-4">
                       <label class="block mb-1">Tanggal</label>
                       <input type="date"
                              name="date"
                              value="{{ old('date') }}"
                              class="w-full border rounded px-3 py-2">
                   </div>

                   <div class="mb-4">
                       <label class="block mb-1">Status</label>
                       <select name="status" class="w-full border rounded px-3 py-2">
                           <option value="">-- Pilih Status --</option>
                           <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                           <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                           <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                       </select>
                   </div>

                   <button type="submit"
                           class="px-4 py-2 bg-blue-600 text-white rounded">
                       Simpan
                   </button>
               </form>

           </div>
       </div>
   </div>
</x-app-layout>
