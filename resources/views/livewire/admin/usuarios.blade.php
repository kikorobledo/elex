<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4">Usuarios</flux:heading>

    <div class="flex gap-5 items-center">

        <flux:input size="sm" placeholder="Buscar..." class="" wire:model.live="search"/>

        <flux:button wire:click="abrirModalCrear">Agregar</flux:button>

    </div>

    <flux:table :paginate="$this->usuarios" wire:loading.class.delaylongest="opacity-50">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Nombre</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'telefono'" :direction="$sortDirection" wire:click="sort('telefono')">Teléfono</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">Correo</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'candidato_id'" :direction="$sortDirection" wire:click="sort('candidato_id')">Candidato</flux:table.column>
            <flux:table.column >Rol</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->usuarios as $usuario)

                <flux:table.row>
                    <flux:table.cell>{{ $usuario->name }}</flux:table.cell>
                    <flux:table.cell>{{ $usuario->telefono }}</flux:table.cell>
                    <flux:table.cell>{{ $usuario->email }}</flux:table.cell>
                    <flux:table.cell>{{ $usuario->candidato->name ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell>{{  implode(', ', $usuario->getRoleNames()->toArray()) }}</flux:table.cell>
                    <flux:table.cell>

                        <flux:dropdown>

                            <flux:button icon:trailing="chevron-down" size="xs"></flux:button>

                            <flux:menu>

                                <flux:menu.item icon="pencil" wire:click="abrirModalEditar( {{ $usuario->id }})">Editar</flux:menu.item>

                                <flux:menu.separator />

                                <flux:menu.item icon="arrow-path-rounded-square" wire:click="resetearPassword( {{ $usuario->id }})">Resetear contraseña</flux:menu.item>

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
                        Nuevo Usuario
                    @elseif($editar)
                        Editar Usuario
                    @endif
                </flux:heading>

            </div>

            <flux:input label="Nombre" wire:model="modelo_editar.name"/>

            <flux:input type="phone" label="Teléfono" wire:model="modelo_editar.telefono"/>

            <flux:input type="email" label="Correo" wire:model="modelo_editar.email"/>

            <flux:select variant="listbox" searchable placeholder="Selecciona un estado..." wire:model.live="modelo_editar.status">

                <flux:select.option value="activo">Activo</flux:select.option>
                <flux:select.option value="inactivo">Inactivo</flux:select.option>

            </flux:select>

            <flux:error name="modelo_editar.status" />

            <flux:select variant="listbox" searchable placeholder="Selecciona un rol..." wire:model.live="roleId">

                @foreach ($roles as $item)

                    <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>

                @endforeach

            </flux:select>

            <flux:error name="roleId" />

            <flux:select variant="listbox" searchable placeholder="Selecciona un candidato..." wire:model="modelo_editar.candidato_id">

                @foreach ($candidatos as $candidato)

                    <flux:select.option value="{{ $candidato->id }}">{{ $candidato->name }}</flux:select.option>

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
