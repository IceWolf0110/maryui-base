<a href="/" wire:navigate>
    <!-- Hidden when collapsed -->
    <div {{ $attributes->class(["hidden-when-collapsed"]) }}>
        <div class="flex gap-2 w-fit">
            <x-icon name="o-heart" label="{{ $slot }}" class="w-6 -mb-1.5" />
        </div>
    </div>

    <!-- Display when collapsed -->
    <div class="display-when-collapsed hidden mx-5 mt-5 mb-1 h-[28px]">
        <x-icon name="s-cube" class="w-6 -mb-1.5 text-purple-500" />
    </div>
</a>
