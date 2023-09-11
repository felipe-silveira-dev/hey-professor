<div>
    <form wire:submit.prevent="upload" class="flex flex-col space-y-4">
        <input type="file" wire:model="file" class="border border-gray-300 rounded-md p-2">
        <button type="submit" class="bg-blue-500 text-white rounded-md p-2">
            Upload
        </button>
    </form>

    @if ($file)
        <div class="flex flex-col space-y-4">
            <img src="{{ $file->temporaryUrl() }}" alt="" class="w-64 h-64 object-cover">

            <div class="flex flex-col space-y-2">
                <span class="font-bold">Path</span>
                <span>{{ $file->getRealPath() }}</span>
            </div>
            <div class="flex flex-col space-y-2">
                <span class="font-bold">Name</span>
                <span>{{ $file->getClientOriginalName() }}</span>
            </div>
            <div class="flex flex-col space-y-2">
                <span class="font-bold">Size</span>
                <span>{{ $file->getSize() }}</span>
            </div>
            <div class="flex flex-col space-y-2">
                <span class="font-bold">Extension</span>
                <span>{{ $file->getClientOriginalExtension() }}</span>
            </div>
            <div class="flex flex-col space-y-2">
                <span class="font-bold">Mime Type</span>
                <span>{{ $file->getMimeType() }}</span>
            </div>
        </div>
    @endif
</div>
