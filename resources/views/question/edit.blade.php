<x-app-layout>
    <x-slot name="header">
        <x-header :title="__('Edit Question')" />
    </x-slot>
    <x-container>
        <x-form put :action="route('question.update', $question)">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." :value="$question->question"/>
            <x-button.primary type="submit" text="Save" />
            <x-button.reset type="reset" text="Cancel" />
        </x-form>
    </x-container>
</x-app-layout>
