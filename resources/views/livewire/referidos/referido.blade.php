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

                        <flux:heading class="mb-0">Telefono</flux:heading>
                        <flux:text >
                            <span x-on:click="navigator.clipboard.writeText($refs.telefono.innerText); $flux.toast({variant: 'success', text:'El número de teléfono se copió al porta papeles'})" x-ref="telefono" class="cursor-pointer">{{ $referido->telefono }}</span>

                            <flux:link href="https://api.whatsapp.com/send?phone=52{{ $referido->telefono }}" external class="ml-3">

                                <flux:button tooltip="Whatsapp" size="xs" icon:trailing="phone"></flux:button>

                            </flux:link>

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

                    <flux:heading size="lg">Donde votar</flux:heading>

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

                    </div>

                    <div class="space-y-5">

                        <flux:heading class="mb-0">Casilla</flux:heading>
                        <flux:text >{{ $referido->seccion->casilla }}</flux:text>

                        <flux:heading class="mb-0">Ubicación</flux:heading>
                        <flux:text >{{ $referido->seccion->ubicacion }}</flux:text>

                    </div>

                </div>

            </flux:card>

        </div>

        <div>

            <flux:card class="space-y-6">

                <div class="flex items-center justify-between">

                    <flux:heading size="lg">Comentarios</flux:heading>

                    <flux:modal.trigger name="speach">
                        <flux:button size="sm">Ver dialogo</flux:button>
                    </flux:modal.trigger>

                </div>

                <div class="space-y-2">

                    <flux:modal.trigger name="modal">

                        <flux:button variant="primary" class="w-full">Agregar nuevo comentario</flux:button>

                    </flux:modal.trigger>

                </div>

                <div class="space-y-6">

                    @foreach ($referido->comentarios->reverse() as $comentario)

                        <flux:card class="space-y-2">

                            <flux:badge color="{{ $comentario->estadoColor }}" size="sm">{{ ucfirst($comentario->status) }}</flux:badge>

                            <flux:heading class="mb-0">Comentario</flux:heading>
                            <flux:text >{{ $comentario->contenido }}</flux:text>
                            <flux:text class="text-xs text-right">{{ $comentario->created_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true, 3) }}</flux:text>

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
                <flux:select.option value="tel. error">Tel. error</flux:select.option>
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

    <flux:modal name="speach" class="md:w-96">

        <div class="space-y-6">

            <div>

                <flux:heading size="lg">Inicia la llamada:</flux:heading>
                <flux:text class="mt-2">Referido: —Bueno…</flux:text>

                <flux:text class="mt-2">—Mi nombre es [tu nombre (Falso)], estoy colaborando con el equipo de participación ciudadana para la elección del 1 de junio.</flux:text>

                <flux:heading size="lg">Fase de verificación:</flux:heading>
                <flux:text class="mt-2">
                    —Estamos haciendo una breve verificación para confirmar que usted está en nuestra lista de personas promovidas para participar este domingo.
                    ¿Me puede confirmar si su nombre completo es [Nombre]?
                    ¿Usted vive en el municipio de [Municipio] y vota en la sección [Sección/Casilla si se conoce]?
                </flux:text>

                <flux:heading size="lg">Confirmación de participación:</flux:heading>
                <flux:text class="mt-2">
                    —Perfecto. ¿Usted tiene pensado acudir a votar este domingo 1 de junio?
                    (si responde sí)
                    —Excelente, solo le pedimos que nos confirme si recuerda la ubicación de su casilla o si necesita que se la confirmemos.
                </flux:text>

                <flux:heading size="lg">Cierre amable:</flux:heading>
                <flux:text class="mt-2">
                    —Muchísimas gracias. Lo estaremos acompañando durante la jornada. Cualquier cosa, puede contactarse con su referente o con nosotros.
                    ¡Buen día y gracias por participar activamente!
                </flux:text>

                <flux:heading size="lg">¿Y si dice que no va a votar o tiene dudas?</flux:heading>
                <flux:text class="mt-2">
                    —Respetamos totalmente su decisión. Solo es importante para nosotros saber si hay algún motivo que le impida acudir (horario, ubicación, no está interesada en participar, o alguna otra situación.), por si podemos ayudarle a resolverlo.
                </flux:text>

            </div>

        </div>

    </flux:modal>

</div>