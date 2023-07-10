<x-app-layout>
    <x-slot name="header">
        <x-header :title="__('Timeline')" />
    </x-slot>
    <x-container>
        <div class="dark:text-gray-200">
            <x-search route="dashboard" placeholder="Search questions..." />
            @if ($questions->isEmpty())
                <x-empty title="No questions found" description="Try to search for another question." />
            @else
                @foreach ($questions as $item)
                    <x-question :question="$item" />
                @endforeach
                {{ $questions->withQueryString()->links() }}
            @endif
        </div>
    </x-container>
</x-app-layout>
