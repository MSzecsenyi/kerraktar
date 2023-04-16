<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="items-center p-6 text-center bg-white border-b border-gray-200">
                    <p>
                        Nincs jogosultságod a webes felülethez, használd a mobil alkalmazást!
                    </p>
                    <div class="mt-4">
                        <div class="flex items-center justify-center">
                            <a href="https://play.google.com/store/apps/details?id=com.example.myapp" target="_blank"
                                class="block">
                                <img class="w-56 mx-auto" src="{{ asset('src/google-play-badge.png') }}"
                                    alt="Google Play">
                            </a>
                        </div>
                        <div class="flex items-center justify-center">
                            <a href="https://apps.apple.com/us/app/google/id284815942?itsct=apps_box_badge&amp;itscg=30200"
                                class="block">
                                <img src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=250x83&amp;releaseDate=1549929600"
                                    alt="Download on the App Store" class="w-48">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
