<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    <div class="grid auto-rows-min gap-4 md:grid-cols-3">

        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">

            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

            <flux:heading size="xl">{{ $referentes }}</flux:heading>
            <flux:text class="text-2xl">Referentes.</flux:text>
            <flux:text class="text-4xl">{{ $referentes }}</flux:text>

        </div>

        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

            <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 ">
                <flux:subheading>Referidos</flux:subheading>
                <flux:heading size="xl" class="mb-2">{{ $referidos }}</flux:heading>
                {{-- <div class="flex items-center gap-1 font-medium text-sm @if ($stat['trendUp']) text-green-600 dark:text-green-400 @else text-red-500 dark:text-red-400 @endif">
                    <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" /> {{ $stat['trend'] }}
                </div> --}}
                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>

        </div>

        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>

    </div>

    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
    </div>

</div>