<x-app-layout>
    <x-slot name="header">
        <x-header :title="__('My Questions')" />
    </x-slot>
    <x-container>
        <x-form post :action="route('question.store')">
            <x-textarea label="Question" name="question" placeholder="Ask me anything..." />
            <x-button.primary type="submit" text="Save" />
            <x-button.reset type="reset" text="Cancel" />
        </x-form>
        <hr class="my-4 border-gray-700 border-dashed">
        <div class="dark:text-gray-200">
            {{-- My Questions --}}
            <div>
                <h2 class="text-2xl font-semibold">My Questions</h2>
            </div>
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Question</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('draft', '=', false) as $item)
                        <x-table.tr>
                            <x-table.td>{{ $item->question }}</x-table.td>
                            <x-table.td>
                                <x-button.primary text="See Answer" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
            {{-- My Drafts --}}
            <div class="mt-6">
                <h2 class="text-2xl font-semibold">My Drafts</h2>
            </div>
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Draft</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($questions->where('draft', '=', true) as $item)
                        <x-table.tr>
                            <x-table.td>{{ $item->question }}</x-table.td>
                            <x-table.td>
                                <x-form put :action="route('question.publish', $item->id)">
                                    <x-button.primary type="submit" text="Publish" />
                                </x-form>
                                <x-form delete :action="route('question.destroy', $item->id)" onsubmit="return confirm('Are you sure?')">
                                    <x-button.primary type="submit" text="Delete" />
                                </x-form>
                                <x-form patch :action="route('question.archive', $item->id)">
                                    <x-button.primary type="submit" text="Archive" />
                                </x-form>
                                <x-button.primary>
                                    <a href="{{ route('question.edit', $item) }}">Edit</a>
                                </x-button.primary>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
            <div class="mt-6">
                <h2 class="text-2xl font-semibold">My Archive Questions</h2>
            </div>
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Draft</x-table.th>
                        <x-table.th>Actions</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @foreach ($archivedQuestions as $item)
                        <x-table.tr>
                            <x-table.td>{{ $item->question }}</x-table.td>
                            <x-table.td>
                                <x-form patch :action="route('question.restore', $item->id)">
                                    <x-button.primary type="submit" text="Restore" />
                                </x-form>
                                <x-form delete :action="route('question.destroy', $item->id)" onsubmit="return confirm('Are you sure?')">
                                    <x-button.primary type="submit" text="Delete" />
                                </x-form>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>
</x-app-layout>
