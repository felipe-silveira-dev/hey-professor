@props(['question'])
<div class="flex flex-col mb-4 min-w-full">
    <div class="flex flex-row justity-between min-w-full">
        <div class="flex flex-col mt-2 border dark:border-gray-800 p-4 rounded-lg shadow-lg min-w-full">
            <div class="text-sm font-semibold">{{ $question->question }}</div>
            <div class="text-xs dark:text-gray-500">{{ $question->created_at->diffForHumans() }}</div>
            <div class="w-full flex justify-between items-end">
                <div class="flex space-x-2">
                    <x-form :action="route('question.like', $question)">
                        <button class="flex space-x-1 text-blue-700">
                            <x-icons.thumbs-up class="w-6 h-6 hover:text-blue-800 cursor-pointer" />
                            <span>{{ $question->votes_sum_like ?: 0 }}</span>
                        </button>
                    </x-form>
                    <x-form :action="route('question.unlike', $question)">
                        <button class="flex text-red-700 space-x-1">
                            <x-icons.thumbs-down class="w-6 h-6 hover:text-red-800 cursor-pointer" />
                            <span>{{ $question->votes_sum_unlike ?: 0 }}</span>
                        </button>
                    </x-form>
                </div>
                <x-button.primary text="Answer" />
            </div>
        </div>
    </div>
</div>
