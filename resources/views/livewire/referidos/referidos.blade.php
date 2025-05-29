<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Referidos</flux:heading>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>

    <flux:table :paginate="!auth()->user()->hasRole('Telefonista') ? $this->referidos : null">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'referente_id'" :direction="$sortDirection" wire:click="sort('referente_id')">Referente</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection" wire:click="sort('nombre')">Nombre</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection" wire:click="sort('status')">Status</flux:table.column>
            @if(auth()->user()->hasRole(['Administrador', 'Supervisor']))
                <flux:table.column sortable :sorted="$sortBy === 'candidato_id'" :direction="$sortDirection" wire:click="sort('candidato_id')">Candidato</flux:table.column>
            @endif
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->referidos as $referido)

                <flux:table.row>
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="md" src="{{ $referido->referente->avatarUrl() }}" />
                        {{ $referido->referente->nombre }}
                    </flux:table.cell>
                    <flux:table.cell>{{ $referido->nombre }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="{{ $referido->estadoColor }}" size="sm">{{ ucfirst($referido->status) }}</flux:badge>
                    </flux:table.cell>
                    @if(auth()->user()->hasRole(['Administrador', 'Supervisor']))
                        <flux:table.cell>{{ $referido->candidato->name ?? 'N/A' }}</flux:table.cell>
                    @endif
                    <flux:table.cell>

                        @if (!$referido->seccion_id)
                            <flux:badge size="sm" color="red">Asignar sección</flux:badge>
                        @else
                            <flux:button size="xs" variant="filled" href="{{ route('referido', $referido) }}">Ver detalles</flux:button>
                        @endif

                        <flux:button size="xs" variant="filled" wire:click="abrirModalEditar( {{ $referido->id }})">Editar</flux:button>

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
                        Nuevo Referido
                    @elseif($editar)
                        Editar Referido
                    @endif

                </flux:heading>

            </div>

            <flux:select variant="listbox" searchable placeholder="Selecciona un referente..." wire:model="modelo_editar.referente_id">

                @foreach ($referentes as $referente)

                    <flux:select.option value="{{ $referente->id }}">{{ $referente->nombre }}</flux:select.option>

                @endforeach

            </flux:select>

            <flux:select variant="listbox" searchable placeholder="Selecciona un sexo..." wire:model="modelo_editar.sexo">

                <flux:select.option value="Hombre">Hombre</flux:select.option>
                <flux:select.option value="Mujer">Mujer</flux:select.option>

            </flux:select>

            <flux:input label="Nombre" wire:model="modelo_editar.nombre"/>

            <flux:input  mask="9999999999"  label="Teléfono" wire:model="modelo_editar.telefono"/>

            <flux:input label="Calle y número" wire:model="modelo_editar.domicilio"/>

            <flux:input label="Colonia" wire:model="modelo_editar.colonia"/>

            <flux:input type="number" label="Código postal" wire:model="modelo_editar.cp"/>

            <flux:input label="Municipio" wire:model="modelo_editar.municipio"/>

            <flux:input label="Clave electoral" wire:model="modelo_editar.clave_electoral"/>

            <flux:select wire:model="modelo_editar.seccion_id" variant="combobox" :filter="false">

                <x-slot name="input">

                    <flux:select.input wire:model.live="search_seccion" />

                </x-slot>

                @foreach ($this->secciones as $seccion)

                    <flux:select.option value="{{ $seccion->id }}" wire:key="{{ $seccion->id }}">
                        {{ $seccion->seccion }}  - Casilla: {{ $seccion->casilla }} - DF: {{ $seccion->distrito_federal }} - Municipio: {{ $seccion->municipio }}
                    </flux:select.option>

                @endforeach

            </flux:select>

            @if($crear)

                <flux:button variant="primary" wire:click="guardar">Crear</flux:button>

            @else

                <flux:button variant="primary" wire:click="actualizar">Actualizar</flux:button>

            @endif

        </div>

    </flux:modal>

</div>
