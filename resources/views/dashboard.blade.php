<x-app-layout>
    <x-slot name="header">
        <x-header title="Dashboard" />
    </x-slot>
    <x-container>
        <x-form post :action="route('question.store')">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..."/>
            <x-button.primary type="submit" text="Save"/>
            <x-button.reset type="reset" text="Cancel"/>
        </x-form>
        <hr class="my-4 border-gray-700 border-dashed">
        <div class="dark:text-gray-200">
            @foreach ($questions as $item)
                <x-question :question="$item"/>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
