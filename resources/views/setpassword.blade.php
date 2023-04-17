<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Jelszó beállítása') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="relative self-center bg-white rounded-lg ">
                        <x-auth-validation-errors :errors="$errors" />
                        <div class="px-6 py-6 lg:px-8">
                            <form class="space-y-6" action="{{ route('setpassword_store') }}" method="POST">
                                @csrf
                                <!-- Password -->
                                <div class="mt-4">
                                    <x-label for="password" :value="__('Password')" />

                                    <x-input id="password" class="block w-full mt-1" type="password" name="password"
                                        required autocomplete="new-password" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4">
                                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                    <x-input id="password_confirmation" class="block w-full mt-1" type="password"
                                        name="password_confirmation" required />
                                </div>

                                <x-button class="ml-4">
                                    {{ __('Jelszó mentése') }}
                                </x-button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
