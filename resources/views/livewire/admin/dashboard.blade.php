<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    <flux:heading size="xl" level="1" class="mb-4">Referidos por stauts</flux:heading>

    <div class="grid auto-rows-min gap-4 md:grid-cols-4 mb-12">

        @foreach ($referidos as $referido)

            <div class="px-4 border border-neutral-200 dark:border-neutral-700 overflow-hidden rounded-xl bg-zinc-50 dark:bg-zinc-700 flex items-center gap-6" wire:key="referido-{{ $loop->index }}">

                <a class="mx-auto text-center flex items-center gap-4 cursor-pointer" href="{{ route('referidos') . '?status=' . $referido->status }}">

                    <flux:text size="xl">{{ $referido->count }}</flux:text>

                    <flux:text size="xl">{{ ucfirst($referido->status) }}</flux:text>

                </a>

            </div>

        @endforeach

    </div>

    <flux:heading size="xl" level="1" class="mb-4">Telefonistas con mas actividades</flux:heading>

    <div class="grid auto-rows-min gap-4 md:grid-cols-4 mb-12">

        @foreach ($telefonistas as $telefonista)

            <div class="px-4 border border-neutral-200 dark:border-neutral-700 overflow-hidden rounded-xl bg-zinc-50 dark:bg-zinc-700 flex items-center gap-6" wire:key="referido-{{ $loop->index }}">

                <div class="mx-auto text-center flex items-center gap-4">

                    <flux:text size="xl">{{ $telefonista->name }}</flux:text>

                    <flux:text size="xl">{{ $telefonista->comentarios_count }}</flux:text>

                </div>

            </div>

        @endforeach

    </div>

</div>