<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Raktárak') }}
            </h2>
            {{-- New store modal toggle button --}}
            <x-button class="mx-8" data-modal-target="new-store-modal">
                {{ __('Új raktár') }}
            </x-button>
        </div>
    </x-slot>

    <!-- Add store modal -->
    <div id="new-store-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full h-screen max-h-full p-4 overflow-x-hidden overflow-y-auto md:inset-0">
        <div class="relative w-[500px] ">
            <!-- Modal content -->
            <div class="relative self-center mt-40 bg-white rounded-lg shadow w-ű">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-hide="new-store-modal">
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Új raktár létrehozása</h3>
                    <form class="space-y-6" action="{{ route('store_store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="district" class="block mb-2 text-sm font-medium text-gray-900">Kerület</label>
                            <select id="district" name="district"
                                class="block w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 p-2.5"
                                required>
                                <option value selected disabled>Válassz kerületet</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value={{ $i }}>{{ $i }}. kerület</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="address"
                                class="block w-full mb-2 text-sm font-medium text-gray-900">Cím</label>
                            <x-input type="text" name="address" class="w-full" id="address"
                                placeholder="Széchenyi tér 1." required />
                        </div>
                        <label for="storekeepers"
                            class="block w-full mb-2 text-sm font-medium text-gray-900">Raktáros</label>
                        <select id="storekeepers" name="storekeepers[]" required multiple
                            class="block w-full rounded-lg">
                            <option disabled> Válassz egy kerületet </option>
                        </select>
                        <div>
                            <label for="excelItems"
                                class="block mb-2 text-sm font-medium text-gray-900 select2">Eszközök
                                feltöltése (opcionális)</label>
                            <input type="file" name="excelItems" id="excelItems" />
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Létrehozás</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete store modal --}}

    <div id="delete-store-modal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    delete-modal-hide="delete-store-modal">
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
                    <h3 class="mb-3 text-lg font-normal text-gray-500 dark:text-gray-400">Biztosan törölni akarod
                        ezt a raktárat?</h3>
                    <h4 class="mb-8 text-sm font-normal text-gray-500 dark:text-gray-400">
                        Az összes ide tartozó eszköz is törölve lesz.
                    </h4>
                    <div class="flex justify-between w-2/3 mx-auto">
                        <button delete-modal-hide="delete-store-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 h-9 dark:focus:ring-gray-600 w-28">Mégsem</button>
                        <form id="delete-store-form" action="{{ route('store_destroy', ':storeId') }}" method="POST">
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
                                        Cím
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Kerület
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Eszközök
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center w-[230px]">
                                        Raktáros
                                    </th>
                                    <th scope="col" class="w-12 px-3 py-3">
                                    </th>
                                    <th scope="col" class="w-24 py-3">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stores as $store)
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                            {{ $store->address }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-center whitespace-nowrap">
                                            {{ $store->district }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-center whitespace-nowrap">
                                            {{ $store->items }}
                                        </th>
                                        <th scope="row" class="py-4 font-medium text-center whitespace-nowrap">
                                            <div class="flex w-[250px] justify-center">
                                                <div id="storekeeper-list-{{ $store->id }}">
                                                    @foreach ($store->users as $user)
                                                        {{ $user->name }} <br>
                                                    @endforeach
                                                </div>
                                                <form id="storekeeper-form-{{ $store->id }}"
                                                    action="{{ route('store_update', $store->id) }}" method="POST"
                                                    class="flex hidden">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="flex-wrap h-auto">
                                                        <select id="selectedStorekeepers-{{ $store->id }}"
                                                            name="selectedStorekeepers[]" required multiple
                                                            class="flex-wrap rounded-lg">
                                                        </select>
                                                    </div>
                                                    <button type="submit"
                                                        class="px-3 py-2 my-auto ml-3 font-bold text-white bg-green-700 rounded-full hover:bg-black">
                                                        <i class="fas fa-check-square"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-3 py-4 font-medium text-center whitespace-nowrap">
                                            <button id="storekeeper-edit-toggle-{{ $store->id }}"
                                                class="px-4 py-2 font-bold text-white bg-green-700 rounded-full hover:bg-black">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </th>
                                        <td class="py-4 text-center">
                                            <x-button class="mx-8" data-modal-target="delete-store-modal"
                                                delete-modal-target="delete-store-modal"
                                                data-store-id="{{ $store->id }}">
                                                {{ __('Törlés') }}
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="my-16">Még nincsen létrehozott raktár</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $stores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    //Add store modal on/off buttons
    const $modalElement = document.querySelector('#new-store-modal');

    const modalOptions = {
        placement: 'center-center',
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-300 bg-opacity-50 fixed inset-0 z-40',
    }

    const newStoreModal = new Modal($modalElement, modalOptions);

    const newStoreModalOpenButton = document.querySelector('[data-modal-target]')
    const newStoreModalCloseButton = document.querySelector('[data-modal-hide]')

    newStoreModalOpenButton.addEventListener('click', () => {
        newStoreModal.show();
    })
    newStoreModalCloseButton.addEventListener('click', () => {
        newStoreModal.hide();
    })

    //Delete store modal on/off buttons
    const deleteStoreModalElement = document.querySelector('#delete-store-modal');

    const deleteStoreModal = new Modal(deleteStoreModalElement, modalOptions);

    const deleteStoreOpenButtons = document.querySelectorAll('[delete-modal-target]');
    const deleteStoreCloseButtons = document.querySelectorAll('[delete-modal-hide]')

    function getStoreDeleteUrl(storeId, deleteStoreRoute) {
        return deleteStoreRoute.replace(':storeId', storeId);
    }

    const deleteStoreForm = document.querySelector('#delete-store-form');
    deleteStoreOpenButtons.forEach(button => {
        button.addEventListener('click', () => {
            const storeId = button.getAttribute('data-store-id');
            deleteStoreForm.action = getStoreDeleteUrl(storeId, deleteStoreForm.getAttribute('action'));
            deleteStoreModal.show();
        });
    });
    deleteStoreCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            deleteStoreModal.hide();
        });
    });

    // Function to filter storekeepers based on selected district
    var storekeepers = {!! json_encode($storekeepers) !!};

    function filterStorekeepers(district) {
        var filteredStorekeepers = storekeepers.filter(function(storekeeper) {
            return storekeeper.district == district;
        }).map(function(storekeeper) {
            return {
                id: storekeeper.id,
                text: storekeeper.name
            }
        });
        return filteredStorekeepers;
    }

    // Event listener for district dropdown change
    var filteredStorekeepers
    $('#district').on('change', function() {
        var selectedDistrict = $(this).val();
        filteredStorekeepers = filterStorekeepers(selectedDistrict);
        updateSelect2Data(filteredStorekeepers);
    });

    //Select2 dropdowns

    $(document).ready(function() {
        $('#storekeepers').select2({
            selectionCssClass: ":all:",
            placeholder: "Válassz raktárost",
            language: {
                noResults: function() {
                    return "Ebben a kerületben még nincs raktáros";
                }
            },
            closeOnSelect: false,
            data: filteredStorekeepers,
        });
    });

    function updateSelect2Data(newData) {
        $('#storekeepers').empty().select2({
            selectionCssClass: ":all:",
            placeholder: "Válassz raktárost",
            language: {
                noResults: function() {
                    return "Ebben a kerületben még nincs raktáros";
                }
            },
            closeOnSelect: false,
            data: newData,
        });
    }

    // FilePond
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    const inputElement = document.querySelector('input[id="excelItems"]');
    const pond = FilePond.create(inputElement);
    FilePond.setOptions({
        server: {
            url: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        acceptedFileTypes: [
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ],
        labelFileTypeNotAllowed: "Nem megengedett fájltípus",
        fileValidateTypeLabelExpectedTypes: "Kérlek .xls vagy .xlsx fájlt tölts fel",
        labelIdle: '<span class="filepond--label-action"> Válaszd ki</span> vagy húzd ide a feltölteni kívánt eszközlistát',
        maxFileSize: '3MB',
        labelMaxFileSizeExceeded: 'Túl nagy méretű fájl',
        labelMaxFileSize: 'Maximum 3 MB',
    })

    // editStorekeepers toggle, setting the select data
    @foreach ($stores as $store)
        const storekeepersInStore{{ $store->id }} = {!! json_encode($store->users) !!}
        const storekeeperList{{ $store->id }} = document.getElementById('storekeeper-list-{{ $store->id }}');
        const storekeeperForm{{ $store->id }} = document.getElementById('storekeeper-form-{{ $store->id }}');
        const toggleButton{{ $store->id }} = document.getElementById(
            'storekeeper-edit-toggle-{{ $store->id }}');

        toggleButton{{ $store->id }}.addEventListener('click', () => {
            storekeeperList{{ $store->id }}.classList.toggle('hidden');
            storekeeperForm{{ $store->id }}.classList.toggle('hidden');
        });

        const filteredStorekeepers{{ $store->id }} = filterStorekeepers({{ $store->district }}).map(function(
            storekeeper) {
            const alreadySelected = storekeepersInStore{{ $store->id }}.some(selectedStorekeeper =>
                storekeeper.id === selectedStorekeeper.id);
            return {
                id: storekeeper.id,
                text: storekeeper.text,
                selected: alreadySelected,
            };
        });

        $(document).ready(function() {
            $('#selectedStorekeepers-{{ $store->id }}').select2({
                selectionCssClass: ":all:",
                dropdownCssClass: ":all:",
                placeholder: "Válassz raktárost",
                language: {
                    noResults: function() {
                        return "Ebben a kerületben még nincs raktáros";
                    }
                },
                closeOnSelect: false,
                data: filteredStorekeepers{{ $store->id }},
            });
        });
    @endforeach

    $(document).ready(function() {
        $('.select2-search__field').prop('hidden', true);
    })


    @if ($errors->any())
        newStoreModal.show();
    @endif
</script>
