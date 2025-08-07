<aside class="w-64 h-screen overflow-y-auto scroll-smooth bg-white shadow-lg border-r" x-data="{ openGroups: { yayasan: true, bidang: true, sekolah: true, admin: true }, openSubgroups: {} }">

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

                $subBidang = [
                    'kabid1' => ['Koord PU', 'Kls Internasional'],
                    'kabid2' => ['SV.Cleaning', 'Sarpras', 'UUS', 'AJS', 'CS', 'BSP', 'QFC'],
                    'kabid3' => ['PPDB', 'Bidang 3', 'Medsos Sekolah', 'Medsos Siswa'],
                ];

                $subSekolah = [
                    'sma' => [
                        'PKS Kurikulum',
                        'PKS Kesiswaan',
                        'Koordinator Program Unggulan',
                        'Tim literasi',
                        'Tim UTBK',
                        'Tim Evakuasi',
                        'Tim pengembangan kurikulum',
                        'Tim sarana',
                        'PJ organisasi',
                        'PJ ibadah',
                        'PJ media',
                        'PJ lomba',
                        'PJ ekskul',
                        'BK',
                    ],
                    'smp' => [
                        'Unit',
                        'PKS',
                        'Manajemen Level',
                        'Al-Quran',
                        'Bahasa Arab',
                        'Bahasa Ingris',
                        'Tim Kesiswaan',
                        'Mata Pelajaran',
                        'KS-BK',
                        'KS-Kurikulum',
                        'KS-Kesiswaan',
                    ],
                    'sd' => [
                        'KS-Wakasek',
                        'Managemen',
                        'KS-Koord. Program Unggulan',
                        'KS-Korjen',
                        'KS/Wakasek-BK',
                        'KS/Wakasek-Koord.Wusho',
                        'KS/Wakasek-Koord.Kelulusan',
                        'Tim Bahasa Arab',
                        'Tim Bahasa Inggris',
                        'Tim AQ',
                        'Tim MTK',
                        'Tim PAI',
                        'Umum',
                    ],
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
                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Insert</a>
                        </li>
                        <li><a href="{{ route('meeting.index') }}"
                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Index</a>
                        </li>
                        <li><a href="{{ route('rekap.peserta') }}"
                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Rekap</a>
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
                                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Insert</a>
                                        </li>
                                        <li><a href="{{ url('meeting/index/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Index</a>
                                        </li>
                                        <li><a href="{{ url('meeting/rekap/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md transition text-gray-700 hover:bg-gray-100">Rekap</a>
                                        </li>
                                    </ul>
                                    {{-- @if (isset($subBidang[$r]))
                                        <button
                                            @click="openSubgroups['sub_{{ $r }}'] = !openSubgroups['sub_{{ $r }}']"
                                            class="mt-2 text-xs font-semibold text-gray-500 uppercase px-4 py-1 w-full text-left hover:text-blue-600">
                                            Sub {{ $data['label'] }}
                                        </button>
                                        <ul x-show="openSubgroups['sub_{{ $r }}']" x-transition
                                            class="ml-4 mt-1 space-y-1">
                                            @foreach ($subBidang[$r] as $sub)
                                                <li><a href="#"
                                                        class="block px-4 py-1 text-sm rounded-md text-gray-700 hover:bg-gray-100">{{ $sub }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif --}}
                                    @if (isset($subBidang[$r]))
                                        <button
                                            @click="openSubgroups['sub_{{ $r }}'] = !openSubgroups['sub_{{ $r }}']"
                                            class="mt-2 text-xs font-semibold text-gray-500 uppercase px-4 py-1 w-full text-left hover:text-blue-600 flex items-center justify-between">
                                            <span>Sub {{ $data['label'] }}</span>
                                            <svg :class="{ 'transform rotate-90': openSubgroups['sub_{{ $r }}'] }"
                                                class="w-4 h-4 transition-transform duration-200" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>

                                        <ul x-show="openSubgroups['sub_{{ $r }}']" x-transition
                                            class="ml-4 mt-1 space-y-1">
                                            @foreach ($subBidang[$r] as $sub)
                                                <li>
                                                    <a href="#"
                                                        class="block px-4 py-1 text-sm rounded-md text-gray-700 hover:bg-gray-100">
                                                        {{ $sub }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
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
                                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Insert</a>
                                        </li>
                                        <li><a href="{{ route('meeting.' . $data['slug'] . '.index') }}"
                                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Index</a>
                                        </li>
                                        <li><a href="{{ url('meeting/rekap/' . $data['slug']) }}"
                                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Rekap</a>
                                        </li>
                                    </ul>
                                    {{-- @if (isset($subSekolah[$data['slug']]))
                                        <button
                                            @click="openSubgroups['sub_{{ $data['slug'] }}'] = !openSubgroups['sub_{{ $data['slug'] }}']"
                                            class="mt-2 text-xs font-semibold text-gray-500 uppercase px-4 py-1 w-full text-left hover:text-blue-600">
                                            Sub {{ $data['label'] }}
                                        </button>
                                        <ul x-show="openSubgroups['sub_{{ $data['slug'] }}']" x-transition
                                            class="ml-4 mt-1 space-y-1">
                                            @foreach ($subSekolah[$data['slug']] as $sub)
                                                <li><a href="#"
                                                        class="block px-4 py-1 text-sm rounded-md text-gray-700 hover:bg-gray-100">{{ $sub }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif --}}
                                    @if (isset($subSekolah[$data['slug']]))
                                        <button
                                            @click="openSubgroups['sub_{{ $data['slug'] }}'] = !openSubgroups['sub_{{ $data['slug'] }}']"
                                            class="mt-2 flex items-center justify-between text-xs font-semibold text-gray-500 uppercase px-4 py-1 w-full text-left hover:text-blue-600 transition">
                                            <span>Sub {{ $data['label'] }}</span>
                                            <svg :class="{ 'rotate-180': openSubgroups['sub_{{ $data['slug'] }}'] }"
                                                class="w-4 h-4 transform transition-transform duration-200"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        <ul x-show="openSubgroups['sub_{{ $data['slug'] }}']" x-transition
                                            class="ml-6 mt-1 space-y-1 text-sm" x-cloak>
                                            @foreach ($subSekolah[$data['slug']] as $sub)
                                                <li>
                                                    <a href="#"
                                                        class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100 transition">{{ $sub }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
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
                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Insert</a></li>
                        <li><a href="{{ url('admin') }}"
                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Index</a></li>
                        <li><a href="{{ route('rekap.peserta') }}"
                                class="block px-4 py-1 rounded-md text-gray-700 hover:bg-gray-100">Rekap</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </nav>
</aside>
