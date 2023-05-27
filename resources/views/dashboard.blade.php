<x-app-layout>
    <x-slot name="header">
        <x-header :title="__('Timeline')" />
    </x-slot>
    <x-container>
        <div class="dark:text-gray-200">
            @foreach ($questions as $item)
                <x-question :question="$item"/>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
