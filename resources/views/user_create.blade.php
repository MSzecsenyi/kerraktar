<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Új felhasználó létrehozása') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="relative self-center bg-white rounded-lg ">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div class="px-6 py-6 lg:px-8">
                            <form class="space-y-6" action="{{ route('user_store') }}" method="POST">
                                @csrf
                                <div class="grid gap-6 md:grid-cols-2">
                                    <div class="grid grid-rows-2 gap-6">
                                        <div>
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900 max-w-fit">Email</label>
                                            <x-input type="email" name="email" id="email"
                                                placeholder="kerraktar@cserkesz.hu" class="w-full" required />
                                        </div>
                                        <div>
                                            <label for="name"
                                                class="block mb-2 text-sm font-medium text-gray-900">Csapatnév</label>
                                            <x-input type="text" name="name" id="name"
                                                placeholder="Uborka János cscs." class="w-full" required />
                                        </div>
                                    </div>
                                    <div class="grid grid-rows-2 gap-6">
                                        <div>
                                            <label for="group_number"
                                                class="block mb-2 text-sm font-medium text-gray-900">Csapatszám</label>
                                            <x-input type="text" name="group_number" id="group_number"
                                                placeholder="9999." class="w-full" required />
                                        </div>
                                        <div>
                                            <label for="district"
                                                class="block mb-2 text-sm font-medium text-gray-900">Kerület</label>
                                            <select id="district"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 "
                                                required>
                                                <option selected="">Válassz kerületet!</option>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value={{ $i }}>{{ $i }}. kerület
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900">Szerepkör</label>
                                <ul
                                    class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="group-checkbox-list" type="checkbox" value=""
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="group-checkbox-list"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Csapat
                                            </label>
                                        </div>
                                    </li>
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="storekeeper-checkbox-list" type="checkbox" value=""
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="storekeeper-checkbox-list"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Raktáros</label>
                                        </div>
                                    </li>
                                    <li class="w-full dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="admin-checkbox-list" type="checkbox" value=""
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="admin-checkbox-list"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Admin</label>
                                        </div>
                                    </li>
                                </ul>
                                <div class="text-center"><button type="submit"
                                        class="text-white w-2/5 px-auto bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Meghívó
                                        link elküldése</button></div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
