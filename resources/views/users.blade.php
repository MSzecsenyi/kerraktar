<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Felhasználók') }}
            </h2>
            {{-- New user modal toggle button --}}
            <x-button class="mx-8" data-modal-target="new-user-modal">
                {{ __('Új felhasználó') }}
            </x-button>
        </div>
    </x-slot>

    <!-- Main modal -->
    <div id="new-user-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full h-screen max-h-full p-4 overflow-x-hidden overflow-y-auto md:inset-0">
        <div class="relative w-full max-h-full max-w-fit">
            <!-- Modal content -->
            <div class="relative self-center mt-40 bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-hide="new-user-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Új felhasználó létrehozása</h3>
                    <form class="space-y-6" action="{{ route('user_store') }}" method="POST">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <x-input type="email" name="email" id="email"
                                        placeholder="kerraktar@cserkesz.hu" required />
                                </div>
                                <div>
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900">Csapatnév</label>
                                    <x-input type="text" name="name" id="name"
                                        placeholder="Uborka János cscs." required />
                                </div>
                            </div>
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <label for="group_number"
                                        class="block mb-2 text-sm font-medium text-gray-900">Csapatszám</label>
                                    <x-input type="text" name="group_number" id="group_number" placeholder="9999."
                                        required />
                                </div>
                                <div>
                                    <label for="district"
                                        class="block mb-2 text-sm font-medium text-gray-900">Kerület</label>
                                    <select id="district"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                        <option selected="">Válassz kerületet!</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value={{ $i }}>{{ $i }}. kerület</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Szerepkör</label>
                        <ul
                            class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="group-checkbox-list" type="checkbox" value=""
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="group-checkbox-list"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Csapat
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="storekeeper-checkbox-list" type="checkbox" value=""
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="storekeeper-checkbox-list"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Raktáros</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="admin-checkbox-list" type="checkbox" value=""
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="admin-checkbox-list"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Admin</label>
                                </div>
                            </li>
                        </ul>

                        <button type="submit"
                            class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Meghívó
                            link elküldése</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Név
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Csapatszám
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Kerület
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Szerepkör
                                    </th>
                                    <th scope="col" class="w-48 px-6 py-3" />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                            {{ $user->name }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-center">
                                            {{ $user->group_number }}
                                        </th>
                                        <td class="px-6 py-4 text-center">
                                            {{ $user->district }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($user->is_admin)
                                                Admin
                                            @endif
                                            @if ($user->is_group)
                                                Csapat
                                            @endif
                                            @if ($user->is_storekeeper)
                                                Raktáros
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($user->has_requests)
                                                Vannak visszahozatlan eszközei
                                            @else
                                                <x-button>
                                                    {{ __('Törlés') }}
                                                </x-button>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="my-16">Még nincsen hozzáadott
                                                felhasználó</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $users->onEachSide(2)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @dd($users) --}}
</x-app-layout>

<script>
    const $modalElement = document.querySelector('#new-user-modal');
    console.log($modalElement)

    const modalOptions = {
        placement: 'center-center',
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-300 bg-opacity-50 fixed inset-0 z-40',
    }

    const newUserModal = new Modal($modalElement, modalOptions);

    const newUserModalOpenButton = document.querySelector('[data-modal-target]')
    const newUserModalCloseButton = document.querySelector('[data-modal-hide]')

    newUserModalOpenButton.addEventListener('click', () => {
        newUserModal.show();
        console.log("click");
    })
    newUserModalCloseButton.addEventListener('click', () => {
        newUserModal.hide();
        console.log("click");
    })

    newUserModal.show()
</script>
