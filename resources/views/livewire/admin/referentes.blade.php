<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Referentes</flux:heading>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>

    <flux:table :paginate="$this->referentes" wire:loading.class.delaylongest="opacity-50">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection" wire:click="sort('nombre')">Nombre</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'telefono'" :direction="$sortDirection" wire:click="sort('telefono')">Teléfono</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'candidato_id'" :direction="$sortDirection" wire:click="sort('candidato_id')">Candidato</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->referentes as $referente)

                <flux:table.row>
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="md" src="{{ $referente->avatarUrl() }}" />
                        {{ $referente->nombre }}
                    </flux:table.cell>
                    <flux:table.cell>{{ $referente->telefono }}</flux:table.cell>
                    <flux:table.cell>{{ $referente->candidato->name ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="xs" variant="filled" wire:click="abrirModalEditar( {{ $referente->id }})">Editar</flux:button>
                    </flux:table.cell>
                </flux:table.row>

            @endforeach

        </flux:table.rows>

    </flux:table>

    <flux:modal name="modal" variant="flyout">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">
                    @if($crear)
                        Nuevo Referente
                    @elseif($editar)
                        Editar Referente
                    @endif
                </flux:heading>

            </div>

            <flux:input label="Nombre" wire:model="modelo_editar.nombre"/>

            <flux:input type="phone" label="Teléfono" wire:model="modelo_editar.telefono"/>

            <flux:select variant="listbox" searchable placeholder="Selecciona un candidato..." wire:model="modelo_editar.candidato_id">

                @foreach ($candidatos as $candidato)

                    <flux:select.option value="{{ $candidato->id }}">{{ $candidato->name }}</flux:select.option>

                @endforeach

            </flux:select>

            <flux:input type="file" wire:model="avatar" label="Avatar"/>

            @if($crear)

                <flux:button variant="primary" wire:click="guardar">Crear</flux:button>

            @else

                <flux:button variant="primary" wire:click="actualizar">Actualizar</flux:button>

            @endif

        </div>

    </flux:modal>

</div>
