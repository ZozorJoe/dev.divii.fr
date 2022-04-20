<x-app-layout>
    <div id="app"></div>
    <x-slot name="script">
        <script src="{{ asset_version('/js/app.js') }}"></script>
    </x-slot>
</x-app-layout>
