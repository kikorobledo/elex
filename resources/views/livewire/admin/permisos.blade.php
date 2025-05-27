<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Permisos</flux:heading>

    <flux:separator  class="my-6"/>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>



    <flux:table :paginate="$this->permisos">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Nombre</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->permisos as $permiso)

                <flux:table.row>
                    <flux:table.cell>{{ $permiso->name }}</flux:table.cell>
                    <flux:table.cell>

                        <flux:button size="xs" variant="filled" wire:click="abrirModalEditar( {{ $permiso->id }})">Editar</flux:button>

                        <flux:modal.trigger name="delete">
                            <flux:button size="xs" variant="danger" wire:click="$set('selected_id', {{ $permiso->id }})">Borrar</flux:button>
                        </flux:modal.trigger>

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
                        Nuevo Permiso
                    @elseif($editar)
                        Editar Permiso
                    @endif
                </flux:heading>

            </div>

            <flux:input label="Nombre" wire:model="modelo_editar.name"/>

            @if($crear)

                <flux:button variant="primary" wire:click="guardar">Crear</flux:button>

            @else

                <flux:button variant="primary" wire:click="actualizar">Actualizar</flux:button>

            @endif

        </div>

    </flux:modal>

    <flux:modal name="delete" class="min-w-[22rem]">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">¿Eliminar información?</flux:heading>

                <flux:text class="mt-2">
                    <p>La información no podrá ser recuperada.</p>
                </flux:text>

            </div>

            <div class="flex gap-2">

                <flux:spacer />

                <flux:modal.close>

                    <flux:button variant="ghost">Cancel</flux:button>

                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="borrar">Eliminar</flux:button>

            </div>

        </div>

    </flux:modal>

</div>
