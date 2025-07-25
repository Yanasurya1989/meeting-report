<aside class="w-64 bg-white shadow-lg border-r" x-data="{ openGroups: { bidang: true, sekolah: true } }">
    <div class="p-6 text-xl font-bold text-blue-600 border-b">
        Admin Panel
    </div>

    <nav class="mt-4">
        <ul class="space-y-2 text-sm">

            {{-- YAYASAN --}}
            @if (auth()->user()->role->name === 'direktur')
                @php
                    $meetingCreatePath = route('meeting.create');
                    $isActive = request()->is('meeting/create');
                @endphp
                <li>
                    <a href="{{ $meetingCreatePath }}"
                        class="flex items-center px-6 py-2 font-medium rounded-md transition
                            {{ $isActive ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                        Yayasan
                    </a>
                </li>
            @endif

            {{-- BIDANG GROUP --}}
            @if (auth()->user()->role->name === 'direktur')
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
                        @foreach (['Bidang1', 'Bidang2', 'Bidang3', 'Bidang4'] as $menu)
                            @php
                                $slug = strtolower($menu);
                                $isActive = request()->is($slug);
                            @endphp
                            <li>
                                <a href="{{ url($slug) }}"
                                    class="block px-4 py-2 rounded-md transition
                                        {{ $isActive ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $menu }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif

            {{-- SEKOLAH GROUP --}}
            @if (auth()->user()->role->name === 'direktur')
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
                        @foreach (['SMA', 'SMP', 'SD'] as $menu)
                            @php
                                $slug = strtolower($menu);
                                $isActive = request()->is($slug);
                            @endphp
                            <li>
                                <a href="{{ url($slug) }}"
                                    class="block px-4 py-2 rounded-md transition
                                        {{ $isActive ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $menu }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif

            {{-- ADMIN MENU --}}
            @if (auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'direktur')
                @php
                    $current = request()->path();
                    $isActiveAdmin = $current === 'admin';
                @endphp
                <li>
                    <a href="{{ url('admin') }}"
                        class="flex items-center px-6 py-2 font-medium rounded-md transition
                            {{ $isActiveAdmin ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Admin
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>
