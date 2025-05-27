<div class="lg:p-12">

    <flux:heading size="xl" level="1" class="mb-4 flex items-center gap-6">{{ $referido->nombre }} <flux:badge color="{{ $referido->estadoColor }}" size="sm">{{ ucfirst($referido->status) }}</flux:badge></flux:heading>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div>

            <flux:card class="space-y-6">

                <div>

                    <flux:heading size="lg">Información general</flux:heading>

                </div>

                <div class="space-y-6 grid grid-cols-2 gap-4">

                    <div class="space-y-5">

                        <flux:heading class="mb-0">Sexo</flux:heading>
                        <flux:text >{{ $referido->sexo }}</flux:text>

                        <flux:heading class="mb-0">Telefono</flux:heading>
                        <flux:text >
                            <span x-on:click="navigator.clipboard.writeText($refs.telefono.innerText); $flux.toast('El número de teléfono se copió al porta papeles')" x-ref="telefono" class="cursor-pointer">{{ $referido->telefono }}</span>
                            <flux:button tooltip="Whatsapp" size="xs" icon:trailing="phone" class="ml-3" href="https://api.whatsapp.com/send?phone=52{{ $referido->telefono }}" _blank></flux:button>
                        </flux:text>

                        <flux:heading class="mb-0">Calle  y #</flux:heading>
                        <flux:text >{{ $referido->domicilio }}</flux:text>

                        <flux:heading class="mb-0">Referente</flux:heading>
                        <flux:text >{{ $referido->referente->nombre }}</flux:text>

                    </div>

                    <div class="space-y-5">

                        <flux:heading class="mb-0">Colonia</flux:heading>
                        <flux:text >{{ $referido->colonia }}</flux:text>

                        <flux:heading class="mb-0">Código postal</flux:heading>
                        <flux:text >{{ $referido->cp }}</flux:text>

                        <flux:heading class="mb-0">Municipio</flux:heading>
                        <flux:text >{{ $referido->municipio }}</flux:text>

                        <flux:heading class="mb-0">Clave electoral</flux:heading>
                        <flux:text >{{ $referido->clave_electoral }}</flux:text>

                    </div>

                </div>

            </flux:card>

        </div>

        <div>

            <flux:card class="space-y-6">

                <div>

                    <flux:heading size="lg">Sección</flux:heading>

                </div>

                <div class="space-y-6 grid grid-cols-2 gap-4">

                    <div class="space-y-5">

                        <flux:heading class="mb-0">Sección</flux:heading>
                        <flux:text >{{ $referido->seccion->seccion }}</flux:text>

                        <flux:heading class="mb-0">Distrito federal</flux:heading>
                        <flux:text >{{ $referido->seccion->distrito_federal }}</flux:text>

                        <flux:heading class="mb-0">Distrito local</flux:heading>
                        <flux:text >{{ $referido->seccion->distrito_local }}</flux:text>

                        <flux:heading class="mb-0">Municipio</flux:heading>
                        <flux:text >{{ $referido->seccion->municipio }}</flux:text>

                        <flux:heading class="mb-0">Localidad</flux:heading>
                        <flux:text >{{ $referido->seccion->localidad }}</flux:text>

                        <flux:heading class="mb-0">Casilla</flux:heading>
                        <flux:text >{{ $referido->seccion->casilla }}</flux:text>

                        <flux:heading class="mb-0">Ubicación</flux:heading>
                        <flux:text >{{ $referido->seccion->ubicacion }}</flux:text>

                    </div>

                    <div class="space-y-5">

                        <flux:heading class="mb-0">Prsidente</flux:heading>
                        <flux:text >{{ $referido->seccion->presidente }}</flux:text>

                        <flux:heading class="mb-0">Secretario 1</flux:heading>
                        <flux:text >{{ $referido->seccion->secretario_1 }}</flux:text>

                        <flux:heading class="mb-0">Secretario 2</flux:heading>
                        <flux:text >{{ $referido->seccion->secretario_1 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 1</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_1 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 2</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_2 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 3</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_3 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 4</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_4 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 5</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_5 }}</flux:text>

                        <flux:heading class="mb-0">Escrutador 6</flux:heading>
                        <flux:text >{{ $referido->seccion->escrutador_6 }}</flux:text>

                        <flux:heading class="mb-0">Suplente 1</flux:heading>
                        <flux:text >{{ $referido->seccion->suplente_1 }}</flux:text>

                        <flux:heading class="mb-0">Suplente 2</flux:heading>
                        <flux:text >{{ $referido->seccion->suplente_2 }}</flux:text>

                        <flux:heading class="mb-0">Suplente 3</flux:heading>
                        <flux:text >{{ $referido->seccion->suplente_3 }}</flux:text>

                    </div>

                </div>

            </flux:card>

        </div>

        <div>

            <flux:card class="space-y-6">

                <div>

                    <flux:heading size="lg">Comentarios</flux:heading>

                </div>

                <div class="space-y-2">

                    <flux:modal.trigger name="modal">

                        <flux:button variant="primary" class="w-full">Agregar nuevo comentario</flux:button>

                    </flux:modal.trigger>

                </div>

                <div class="space-y-6">

                    @foreach ($referido->comentarios as $comentario)

                        <flux:card class="space-y-2">

                            <flux:badge color="{{ $comentario->estadoColor }}" size="sm">{{ ucfirst($comentario->status) }}</flux:badge>

                            <flux:heading class="mb-0">Comentario</flux:heading>
                            <flux:text >{{ $comentario->contenido }}</flux:text>
                            <flux:text class="text-xs text-right">{{ $comentario->created_at }}</flux:text>

                        </flux:card>

                    @endforeach

                </div>

            </flux:card>

        </div>

    </div>

    <flux:modal name="modal" variant="flyout">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">
                        Nuevo Comentario
                </flux:heading>

            </div>

            <flux:select variant="listbox" searchable placeholder="Selecciona un estado..." wire:model="estado">

                <flux:select.option value="nuevo">Nuevo</flux:select.option>
                <flux:select.option value="buzon">Buzon</flux:select.option>
                <flux:select.option value="no contesta">No contesta</flux:select.option>
                <flux:select.option value="no validó referencia">No validó referencia</flux:select.option>
                <flux:select.option value="validó referencia">Validó referencia</flux:select.option>
                <flux:select.option value="invitado">Invitado</flux:select.option>
                <flux:select.option value="reforzado">Reforzado</flux:select.option>
                <flux:select.option value="votado">Votado</flux:select.option>

            </flux:select>

            <flux:textarea rows="10" label="Comentario" wire:model="comentario" />

            <flux:button variant="primary" wire:click="guardar">Crear</flux:button>

        </div>

    </flux:modal>

</div>