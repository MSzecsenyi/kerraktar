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

    <!-- Add user modal -->
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
                <x-auth-validation-errors class="pt-6 pl-10" :errors="$errors" />
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
                                    <select id="district" name="district"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 block w-full p-2.5 "
                                        required>
                                        <option disabled selected value>Válassz kerületet!</option>
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
                                    <input id="is_group" name="is_group" required type="checkbox" value="1"
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_group"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Csapat
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_storekeeper" name="is_storekeeper" required type="checkbox"
                                        value="1"
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_storekeeper"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Raktáros</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_admin" name="is_admin" required type="checkbox" value="1"
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_admin"
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

    {{-- Delete user modal --}}

    <div id="delete-user-modal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    delete-modal-hide="delete-user-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 mx-auto text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Biztosan törölni akarod
                        ezt a felhasználót?</h3>
                    <div class="flex justify-between w-2/3 mx-auto">
                        <button delete-modal-hide="delete-user-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 h-9 dark:focus:ring-gray-600 w-28">Mégsem</button>
                        <form id="delete-user-form" action="{{ route('user_destroy', ':userId') }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <x-button class="justify-center w-28">
                                Igen
                            </x-button>
                        </form>
                    </div>
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
                                                <x-button class="mx-8" data-modal-target="delete-user-modal"
                                                    delete-modal-target="delete-user-modal"
                                                    data-user-id="{{ $user->id }}">
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
</x-app-layout>

<script>
    //Add user modal on/off buttons
    const $modalElement = document.querySelector('#new-user-modal');

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
    })
    newUserModalCloseButton.addEventListener('click', () => {
        newUserModal.hide();
    })

    //Delete user modal on/off buttons
    const deleteUserModalElement = document.querySelector('#delete-user-modal');

    const deleteUserModal = new Modal(deleteUserModalElement, modalOptions);

    const deleteUserOpenButtons = document.querySelectorAll('[delete-modal-target]');
    const deleteUserCloseButtons = document.querySelectorAll('[delete-modal-hide]')

    function getUserDeleteUrl(userId, deleteUserRoute) {
        return deleteUserRoute.replace(':userId', userId);
    }

    const deleteUserForm = document.querySelector('#delete-user-form');
    deleteUserOpenButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');
            deleteUserForm.action = getUserDeleteUrl(userId, deleteUserForm.getAttribute('action'));
            deleteUserModal.show();
        });
    });
    deleteUserCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log('clack');
            deleteUserModal.hide();
        });
    });

    //checkbox selection control
    var requiredCheckboxes = document.querySelectorAll(':required[type="checkbox"]');
    for (var i = 0; i < requiredCheckboxes.length; i++) {
        requiredCheckboxes[i].addEventListener('change', function() {
            var checkedCount = 0;
            for (var j = 0; j < requiredCheckboxes.length; j++) {
                if (requiredCheckboxes[j].checked) {
                    checkedCount++;
                }
            }
            if (checkedCount == 0) {
                for (var j = 0; j < requiredCheckboxes.length; j++) {
                    if (requiredCheckboxes[j] != this) {
                        requiredCheckboxes[j].required = true;
                    }
                }
            } else {
                for (var j = 0; j < requiredCheckboxes.length; j++) {
                    requiredCheckboxes[j].required = false;
                }
            }
        });
    }

    @if ($errors->any())
        newUserModal.show();
    @endif
</script>
