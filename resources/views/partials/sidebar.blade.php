<aside class="w-64 h-screen overflow-y-auto scroll-smooth bg-white shadow-lg border-r" x-data="{ openGroups: { yayasan: true, bidang: true, sekolah: true, admin: true } }">

    <div class="p-6 text-xl font-bold text-blue-600 border-b">
        SIT Qordova
    </div>

    <nav class="mt-4">
        <ul class="space-y-2 text-sm">

            @php
                $role = auth()->user()->role->name;
                $isDirektur = $role === 'direktur';

                $bidangRoles = [
                    'kabid1' => ['label' => 'Bidang 1', 'slug' => 'bidang-satu'],
                    'kabid2' => ['label' => 'Bidang 2', 'slug' => 'bidang-dua'],
                    'kabid3' => ['label' => 'Bidang 3', 'slug' => 'bidang-tiga'],
                    'kabid4' => ['label' => 'Bidang 4', 'slug' => 'bidang-empat'],
                ];

                $schoolRoles = [
                    'ks_sma' => ['label' => 'SMA', 'slug' => 'sma'],
                    'ks_smp' => ['label' => 'SMP', 'slug' => 'smp'],
                    'ks_sd' => ['label' => 'SD', 'slug' => 'sd'],
                ];
            @endphp

            {{-- YAYASAN --}}
            @if ($isDirektur)
                <li>
                    <button @click="openGroups.yayasan = !openGroups.yayasan"
                        class="flex justify-between items-center w-full px-6 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                            Yayasan
                        </span>
                        <svg class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': openGroups.yayasan }" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <ul x-show="openGroups.yayasan" x-transition class="ml-8 mt-1 space-y-1">
                        <li><a href="{{ route('meeting.create.yayasan') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('meeting/create') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Insert</a>
                        </li>
                        <li><a href="{{ route('meeting.index') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('meeting') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Index</a>
                        </li>
                        <li><a href="{{ route('rekap.peserta') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('rekap-peserta') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Rekap</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- BIDANG --}}
            @if ($isDirektur || array_key_exists($role, $bidangRoles))
                <li>
                    <button @click="openGroups.bidang = !openGroups.bidang"
                        class="flex justify-between items-center w-full px-6 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Bidang
                        </span>
                        <svg class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': openGroups.bidang }" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <ul x-show="openGroups.bidang" x-transition class="ml-8 mt-1 space-y-1">
                        @foreach ($bidangRoles as $r => $data)
                            @if ($isDirektur || $role === $r)
                                <li>
                                    <span
                                        class="block px-4 py-2 font-semibold text-gray-600">{{ $data['label'] }}</span>
                                    <ul class="ml-4 space-y-1">
                                        <li><a href="{{ url('meeting/create/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is('meeting/create/' . $data['slug']) ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Insert</a>
                                        </li>
                                        <li><a href="{{ url('meeting/index/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is('meeting/index/' . $data['slug']) ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Index</a>
                                        </li>
                                        <li><a href="{{ url('meeting/rekap/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is('meeting/rekap/' . $data['slug']) ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Rekap</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

            {{-- SEKOLAH --}}
            @if ($isDirektur || array_key_exists($role, $schoolRoles))
                <li>
                    <button @click="openGroups.sekolah = !openGroups.sekolah"
                        class="flex justify-between items-center w-full px-6 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            Sekolah
                        </span>
                        <svg class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': openGroups.sekolah }" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <ul x-show="openGroups.sekolah" x-transition class="ml-8 mt-1 space-y-1">
                        @foreach ($schoolRoles as $r => $data)
                            @if ($isDirektur || $role === $r)
                                <li>
                                    <span
                                        class="block px-4 py-2 font-semibold text-gray-600">{{ $data['label'] }}</span>
                                    <ul class="ml-4 space-y-1">
                                        <li><a href="{{ url($data['slug'] . '/create') }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is($data['slug'] . '/create') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Insert</a>
                                        </li>
                                        <li><a href="{{ url($data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is($data['slug']) ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Index</a>
                                        </li>
                                        <li><a href="{{ route('rekap.peserta') }}"
                                                class="block px-4 py-1 rounded-md transition {{ request()->is('rekap-peserta') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Rekap</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

            {{-- ADMIN --}}
            @if ($isDirektur || $role === 'admin')
                <li>
                    <button @click="openGroups.admin = !openGroups.admin"
                        class="flex justify-between items-center w-full px-6 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Admin
                        </span>
                        <svg class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': openGroups.admin }" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <ul x-show="openGroups.admin" x-transition class="ml-8 mt-1 space-y-1">
                        <li><a href="{{ url('admin/create') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('admin/create') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Insert</a>
                        </li>
                        <li><a href="{{ url('admin') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('admin') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Index</a>
                        </li>
                        <li><a href="{{ route('rekap.peserta') }}"
                                class="block px-4 py-1 rounded-md transition {{ request()->is('rekap-peserta') ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Rekap</a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>
    </nav>
</aside>
