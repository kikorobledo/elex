<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Secciones</flux:heading>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>

    <flux:table :paginate="$this->secciones" wire:loading.class.delaylongest="opacity-50">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'seccion'" :direction="$sortDirection" wire:click="sort('seccion')">Sección</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'distrito_federal'" :direction="$sortDirection" wire:click="sort('distrito_federal')">Distrito federal</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'distrito_local'" :direction="$sortDirection" wire:click="sort('distrito_local')">Distrito local</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'municipio'" :direction="$sortDirection" wire:click="sort('municipio')">Municipio</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'casilla'" :direction="$sortDirection" wire:click="sort('casilla')">Casilla</flux:table.column>
            <flux:table.column>Presidente</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->secciones as $seccion)

                <flux:table.row>
                    <flux:table.cell>{{ $seccion->seccion }}</flux:table.cell>
                    <flux:table.cell>{{ $seccion->distrito_federal }}</flux:table.cell>
                    <flux:table.cell>{{ $seccion->distrito_local }}</flux:table.cell>
                    <flux:table.cell>{{ $seccion->municipio }}</flux:table.cell>
                    <flux:table.cell>{{ $seccion->casilla }}</flux:table.cell>
                    <flux:table.cell>{{ $seccion->presidente }}</flux:table.cell>
                    <flux:table.cell><flux:button size="xs" variant="filled" wire:click="ver({{ $seccion->id }})">Ver</flux:button></flux:table.cell>
                </flux:table.row>

            @endforeach

        </flux:table.rows>

    </flux:table>

    <flux:modal name="ver" variant="flyout">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">Seccion {{ $modelo_editar?->seccion }}</flux:heading>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Distrito Federal:</span> {{ $modelo_editar?->distrito_federal }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Distrito local:</span> {{ $modelo_editar?->distrito_local }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Municipio:</span> {{ $modelo_editar?->municipio }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Casilla:</span> {{ $modelo_editar?->casilla }}</flux:text>

            </div>

            <flux:heading>Ubicación</flux:heading>
            <flux:text class="mt-2 w-md">{{ $modelo_editar?->ubicacion }}</flux:text>

            <div>

                <flux:heading>Presidente</flux:heading>
                <flux:text class="mt-2 w-md">{{ $modelo_editar?->presidente }}</flux:text>

            </div>

            <div>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Secretario 1:</span> {{ $modelo_editar?->secretario_1 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Secretario 2:</span> {{ $modelo_editar?->secretario_2 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 1:</span> {{ $modelo_editar?->escrutador_1 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 2:</span> {{ $modelo_editar?->escrutador_2 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 3:</span> {{ $modelo_editar?->escrutador_3 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 4:</span> {{ $modelo_editar?->escrutador_4 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 5:</span> {{ $modelo_editar?->escrutador_5 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Escrutador 6:</span> {{ $modelo_editar?->escrutador_6 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Suplente 1:</span> {{ $modelo_editar?->suplente_1 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Suplente 2:</span> {{ $modelo_editar?->suplente_2 }}</flux:text>
                <flux:text class="mt-2"><span class="font-medium text-gray-500">Suplente 3:</span> {{ $modelo_editar?->suplente_3 }}</flux:text>

            </div>

        </div>

    </flux:modal>

    <flux:modal name="modal" variant="flyout">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">
                    @if($crear)
                        Nueva Sección
                    @elseif($editar)
                        Editar Sección
                    @endif
                </flux:heading>

            </div>

            <flux:input type="number" label="Sección" wire:model="modelo_editar.seccion"/>

            <flux:input label="Distrito federal" wire:model="modelo_editar.distrito_federal"/>

            <flux:input label="Distrito local" wire:model="modelo_editar.distrito_local"/>

            <flux:input label="Municipio" wire:model="modelo_editar.municipio"/>

            <flux:input label="Localidad" wire:model="modelo_editar.localidad"/>

            <flux:input label="Casilla" wire:model="modelo_editar.casilla"/>

            <flux:input label="Presidente" wire:model="modelo_editar.presidente"/>

            <flux:input label="Secretario 1" wire:model="modelo_editar.secretario_1"/>

            <flux:input label="Secretario 2" wire:model="modelo_editar.secretario_2"/>

            <flux:input label="Escrutador 1" wire:model="modelo_editar.escrutador_1"/>

            <flux:input label="Escrutador 2" wire:model="modelo_editar.escrutador_2"/>

            <flux:input label="Escrutador 3" wire:model="modelo_editar.escrutador_3"/>

            <flux:input label="Escrutador 4" wire:model="modelo_editar.escrutador_4"/>

            <flux:input label="Escrutador 5" wire:model="modelo_editar.escrutador_5"/>

            <flux:input label="Escrutador 6" wire:model="modelo_editar.escrutador_6"/>

            <flux:input label="Suplente 1" wire:model="modelo_editar.suplente_1"/>

            <flux:input label="Suplente 2" wire:model="modelo_editar.suplente_2"/>

            <flux:input label="Suplente 3" wire:model="modelo_editar.suplente_3"/>

            <flux:textarea rows="10" label="Ubicación" wire:model="modelo_editar.ubicacion" />

            @if($crear)

                <flux:button variant="primary" wire:click="guardar">Crear</flux:button>

            @else

                <flux:button variant="primary" wire:click="actualizar">Actualizar</flux:button>

            @endif

        </div>

    </flux:modal>

</div>
