<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Reportes</flux:heading>

    <flux:heading size="lg" level="1" class="mb-4">Referidos ({{ $this->referidos->total() }})</flux:heading>

    <div class="grid grid-cols-1 lg:grid-cols-4 items-end gap-4 mb-12">

        <flux:input label="Municipio" wire:model="municipio"/>

        <flux:select variant="listbox" searchable placeholder="Selecciona un referente..." wire:model.lazy="referente_id" clearable>

            @foreach ($referentes as $referente)

                <flux:select.option value="{{ $referente->id }}">{{ $referente->nombre }}</flux:select.option>

            @endforeach

        </flux:select>

        <flux:select variant="listbox" searchable placeholder="Selecciona un estado..." wire:model.live="status" clearable>

            <flux:select.option value="nuevo">Nuevo</flux:select.option>
            <flux:select.option value="tel. error">Tel. error</flux:select.option>
            <flux:select.option value="buzon">Buzon</flux:select.option>
            <flux:select.option value="no contesta">No contesta</flux:select.option>
            <flux:select.option value="no validó referencia">No validó referencia</flux:select.option>
            <flux:select.option value="validó referencia">Validó referencia</flux:select.option>
            <flux:select.option value="invitado">Invitado</flux:select.option>
            <flux:select.option value="reforzado">Reforzado</flux:select.option>
            <flux:select.option value="votado">Votado</flux:select.option>

        </flux:select>

        <flux:select wire:model.live="seccion_id" variant="combobox" :filter="false" placeholder="Selecciona una sección..." clearable>

            <x-slot name="input">

                <flux:select.input wire:model.live="search_seccion" />

            </x-slot>

            @foreach ($this->secciones as $seccion)

                <flux:select.option value="{{ $seccion->id }}" wire:key="{{ $seccion->id }}">
                    {{ $seccion->seccion }}  - Casilla: {{ $seccion->casilla }} - DF: {{ $seccion->distrito_federal }} - Municipio: {{ $seccion->municipio }}
                </flux:select.option>

            @endforeach

        </flux:select>

        <flux:select variant="listbox" searchable placeholder="Selecciona un candidato..." wire:model.live="modelo_editar.candidato_id" clearable>

            @foreach ($candidatos as $candidato)

                <flux:select.option value="{{ $candidato->id }}">{{ $candidato->name }}</flux:select.option>

            @endforeach

        </flux:select>

        <flux:button variant="primary" wire:click="exportar">Exportar a Excel</flux:button>

    </div>

    <flux:table :paginate="$this->referidos" wire:loading.class.delaylongest="opacity-50">

        <flux:table.columns>
            <flux:table.column >Referente</flux:table.column>
            <flux:table.column >Nombre</flux:table.column>
            <flux:table.column >Status</flux:table.column>
            <flux:table.column >Sección</flux:table.column>
            <flux:table.column >Municipio</flux:table.column>
            @if(auth()->user()->hasRole(['Administrador', 'Supervisor']))
                <flux:table.column >Candidato</flux:table.column>
            @endif
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
                    <flux:table.cell>{{ $referido->seccion?->seccion }}</flux:table.cell>
                    <flux:table.cell>{{ $referido->municipio }}</flux:table.cell>
                    @if(auth()->user()->hasRole(['Administrador', 'Supervisor']))
                        <flux:table.cell>{{ $referido->candidato->name ?? 'N/A' }}</flux:table.cell>
                    @endif
                </flux:table.row>

            @endforeach

        </flux:table.rows>

    </flux:table>

</div>
