<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Roles</flux:heading>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>

    <flux:table :paginate="$this->roles" wire:loading.class.delaylongest="opacity-50">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Nombre</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->roles as $role)

                <flux:table.row>
                    <flux:table.cell>{{ $role->name }}</flux:table.cell>
                    <flux:table.cell>

                        <flux:dropdown>

                            <flux:button icon:trailing="chevron-down" size="xs"></flux:button>

                            <flux:menu>

                                <flux:menu.item icon="pencil" wire:click="abrirModalEditar( {{ $role->id }})">Editar</flux:menu.item>

                                <flux:menu.separator />

                                <flux:modal.trigger name="delete">

                                    <flux:menu.item icon="trash" wire:click="$set('selected_id', {{ $role->id }})">Borrar</flux:menu.item>

                                </flux:modal.trigger>

                            </flux:menu>

                        </flux:dropdown>

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
                        Nuevo Rol
                    @elseif($editar)
                        Editar Rol
                    @endif
                </flux:heading>

            </div>

            <flux:input label="Nombre" wire:model="modelo_editar.name"/>

            @foreach($permisos as $permiso)

                <div class="mb-2 flex flex-wrap gap-2">

                    <label class="border border-gray-400 text-gray-500 px-2 rounded-full py-1 text-xs flex items-center">

                        <input class="bg-white rounded" type="checkbox" wire:model.defer="listaDePermisos" value="{{ $permiso->id }}">

                        <p class="ml-2">{{ $permiso->name }}</p>

                    </label>

                </div>

            @endforeach

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
