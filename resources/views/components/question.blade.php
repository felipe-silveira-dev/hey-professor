@props(['question'])
<div class="flex flex-col mb-4">
    <div class="flex flex-row justity-between">
        <div class="flex flex-col mt-2 border dark:border-gray-800 p-4 rounded-lg shadow-lg">
            <div class="text-sm font-semibold">{{ $question->question }}</div>
            <div class="text-xs dark:text-gray-500">{{ $question->created_at->diffForHumans() }}</div>
            <div class="w-full flex justify-end">
                <x-button.primary text="Answer" />
            </div>
        </div>
    </div>
</div>