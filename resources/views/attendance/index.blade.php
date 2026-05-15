<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Data Absensi Siswa
       </h2>
   </x-slot>

   <div class="py-8">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           @if(session('success'))
               <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                   {{ session('success') }}
               </div>
           @endif

           <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
               <div class="bg-white p-4 rounded shadow">
                   <h3 class="text-gray-600">Jumlah Hadir</h3>
                   <p class="text-2xl font-bold">{{ $jumlahHadir }}</p>
               </div>

               <div class="bg-white p-4 rounded shadow">
                   <h3 class="text-gray-600">Jumlah Izin</h3>
                   <p class="text-2xl font-bold">{{ $jumlahIzin }}</p>
               </div>

               <div class="bg-white p-4 rounded shadow">
                   <h3 class="text-gray-600">Jumlah Sakit</h3>
                   <p class="text-2xl font-bold">{{ $jumlahSakit }}</p>
               </div>
           </div>

           <div class="bg-white p-6 rounded shadow">
               <div class="flex justify-between mb-4">
                   <a href="{{ route('attendance.create') }}"
                      class="px-4 py-2 bg-blue-600 text-white rounded">
                       Tambah Absensi
                   </a>

                   <form method="GET" action="{{ route('attendance.index') }}">
                       <input type="text"
                              name="search"
                              value="{{ $search }}"
                              placeholder="Cari nama siswa"
                              class="border rounded px-3 py-2">

                       <button type="submit"
                               class="px-4 py-2 bg-gray-700 text-white rounded">
                           Search
                       </button>
                   </form>
               </div>

               <table class="w-full border">
                   <thead>
                       <tr class="bg-gray-100">
                           <th class="border p-2">No</th>
                           <th class="border p-2">Nama</th>
                           <th class="border p-2">Kelas</th>
                           <th class="border p-2">Tanggal</th>
                           <th class="border p-2">Status</th>
                           <th class="border p-2">Aksi</th>
                       </tr>
                   </thead>

                   <tbody>
                       @forelse($attendances as $attendance)
                           <tr>
                               <td class="border p-2">
                                   {{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}
                               </td>
                               <td class="border p-2">{{ $attendance->student->name }}</td>
                               <td class="border p-2">{{ $attendance->student->class }}</td>
                               <td class="border p-2">{{ $attendance->date }}</td>
                               <td class="border p-2">{{ $attendance->status }}</td>
                               <td class="border p-2">
                                   <a href="{{ route('attendance.edit', $attendance->id) }}"
                                      class="text-blue-600">
                                       Edit
                                   </a>

                                   <form action="{{ route('attendance.destroy', $attendance->id) }}"
                                         method="POST"
                                         class="inline">
                                       @csrf
                                       @method('DELETE')

                                       <button type="submit"
                                               onclick="return confirm('Yakin ingin menghapus data?')"
                                               class="text-red-600 ml-2">
                                           Hapus
                                       </button>
                                   </form>
                               </td>
                           </tr>
                       @empty
                           <tr>
                               <td colspan="6" class="border p-4 text-center">
                                   Data absensi belum ada.
                               </td>
                           </tr>
                       @endforelse
                   </tbody>
               </table>

               <div class="mt-4">
                   {{ $attendances->links() }}
               </div>
           </div>

       </div>
   </div>
</x-app-layout>
