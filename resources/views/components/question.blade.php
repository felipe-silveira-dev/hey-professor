@props(['question'])
<div class="flex flex-col mb-4">
    <div class="flex flex-row justity-between">
        <div class="flex flex-col mt-2 border dark:border-gray-800 p-4 rounded-lg shadow-lg">
            <div class="text-sm font-semibold">{{ $question->question }}</div>
            <div class="text-xs dark:text-gray-500">{{ $question->created_at->diffForHumans() }}</div>
            <div class="w-full flex justify-between items-end">
                <div class="flex space-x-2">
                    <x-form :action="route('question.like', $question)">
                        <button class="flex space-x-1 text-blue-600">
                            <x-icons.thumbs-up class="w-6 h-6 text-blue-700 hover:text-blue-800 cursor-pointer" />
                            <span>{{ $question->likes }}</span>
                        </button>
                    </x-form>
                    <a href="{{ route('question.like', $question) }}">
                        <x-icons.thumbs-down class="w-6 h-6 text-red-700 hover:text-red-800 cursor-pointer" />
                    </a>
                </div>
                <x-button.primary text="Answer"/>
            </div>
        </div>
    </div>
</div>