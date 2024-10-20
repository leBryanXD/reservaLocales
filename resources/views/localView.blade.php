<x-app-layout>
    <h3 class="text-center mt-4 uppercase font-bold" style="font-size: 2rem;"> {{ $local->nombre }}</h3>
    <main class="grid grid-cols-1 md:grid-cols-2 gap-4 contenedor py-4">

        <section>
            <img class="w-full h-2/4" src="{{$local->imagenes[0]->url}}" alt="Imagen de propiedad">

            <h2 class="text-2xl font-bold text-center mb-3 mt-3">Otros datos</h2>
            <table class="border border-slate-700 rounded-sm w-full text-left shadow-md">
                <thead class="bg-principal text-white text-center">
                    <tr>
                        <th class="px-4 py-2">Metros de ancho</th>
                        <th class="px-4 py-2">Metros de largo</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr class="bg-white even:bg-slate-100">
                        <td class="border px-4 py-2">{{$local->amenidad->anchoMetros}}</td>
                        <td class="border px-4 py-2">{{$local->amenidad->largoMetros}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-5">
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-bath w-5 h-5 inline-block text-blue-500"></i>
                    Num baños: <span class="font-normal">{{ $local->amenidad->noBaños }}</span>
                </p>
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-users w-5 h-5 inline-block text-blue-500"></i>
                    Capacidad max: <span class="font-normal">{{ $local->amenidad->capacidadMax }}</span>
                </p>
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-cube w-5 h-5 inline-block text-blue-500"></i>
                    Num mesas: <span class="font-normal">{{ $local->amenidad->noMesas }}</span>
                </p>
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-chair w-5 h-5 inline-block text-blue-500"></i>
                    Num sillas: <span class="font-normal">{{ $local->amenidad->noSillas }}</span>
                </p>
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-parking w-5 h-5 inline-block text-blue-500"></i>
                    Num parqueos: <span class="font-normal">{{ $local->amenidad->noParques }}</span>
                </p>
                <p class="text-center text-lg font-bold">
                    <i class="fas fa-star w-5 h-5 inline-block text-yellow-500"></i>
                    Otras amenidades: <span class="font-normal">{{ $local->amenidad->otrasAmen }}</span>
                </p>
            </div>
        </section>
        <section>
            <p class="mt-4 text-lg"> {{ $local->descripcion }}</p>
            <table class="border border-slate-700 rounded-sm w-full text-left shadow-md">
                <thead class="bg-principal text-white text-center">
                    <tr>
                        <th class="px-4 py-2">Municipio</th>
                        <th class="px-4 py-2">Precio Renta</th>
                        <th class="px-4 py-2">Precio por Hora</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr class="bg-white even:bg-slate-100">
                        <td class="border px-4 py-2">{{$local->municipio}}</td>
                        <td class="border px-4 py-2">{{$local->precioRenta}}</td>
                        <td class="border px-4 py-2">{{$local->costoHora}}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-center mt-4 text-lg"> Dirección: {{ $local->direccion }}</p>
            <p class="text-center mt-4 text-lg"> Referencia: {{ $local->referencias }}</p>
        </section>
    </main>

    @auth
    <div class="text-center">
        <button id="reservar" class="w-1/2 border rounded-md bg-principal text-white font-bold text-lg p-3 my-5">Reservar</button>
    </div>
    @endauth

    <div id="reservacionContenedor" class="">
        <h3 class="text-center text-xl font-semibold">Llene el formulario para reservar</h3>

        <form id="reservaForm" action="{{ route('local.store') }}" method="POST" class="py-5">
            @csrf
            <input type="hidden" name="local_id" value="{{$local->idLocal}}">
            @auth
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            @endauth
            <input type="hidden" name="total" id="totalInput">
            <input type="hidden" name="cancelada" value="0">

            <div class="w-10/12 md:w-2/4 mx-auto my-6">
                <label for="fechaInicio" class="block text-sm font-medium text-slate-700">Fecha de inicio</label>
                <input type="datetime-local" name="fecha_inicio" id="fechaInicio" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            </div>

            <div class="w-10/12 md:w-2/4 mx-auto my-6">
                <label for="fechaFin" class="block text-sm font-medium text-slate-700">Fecha de Fin</label>
                <input type="datetime-local" name="fecha_fin" id="fechaFin" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            </div>

            <div id="mensajeError" class="text-center text-red-500 font-bold hidden">
                Las fechas no son válidas. Asegúrate de que la fecha de inicio y fin sean correctas y al menos 1 día después de la fecha actual.
            </div>

            <p class="text-center mt-4 text-lg">Total Reserva: $ <span id="totalReserva">0.00</span></p>
            <div class="text-center">
                <button type="button" id="FinRes" class="w-1/2 border rounded-md font-bold text-lg p-3 my-5">Finalizar Reservación</button>
            </div>
        </form>

        <!-- Modal de confirmación -->
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">¿Deseas realizar la reserva?</h2>
                <div class="flex justify-end space-x-4">
                    <button id="cancelBtn" class="px-4 py-2 bg-red-600 text-white rounded-md">Cancelar</button>
                    <button id="confirmBtn" class="px-4 py-2 bg-green-600 text-white rounded-md">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const botonReservar = document.getElementById("reservar");
    const reservacionContenedor = document.getElementById("reservacionContenedor");

    const fechaInicio = document.getElementById("fechaInicio");
    const fechaFin = document.getElementById("fechaFin");
    const mensajeError = document.getElementById("mensajeError");
    const totalReserva = document.getElementById("totalReserva");
    const totalInput = document.getElementById("totalInput");

    const precioPorHora = {
        {
            $local - > costoHora
        }
    };
    const precioRenta = {
        {
            $local - > precioRenta
        }
    };
    const FinRes = document.getElementById("FinRes");

    const confirmModal = document.getElementById("confirmModal");
    const confirmBtn = document.getElementById("confirmBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const reservaForm = document.getElementById("reservaForm");

    FinRes.disabled = true;
    FinRes.classList.add("bg-slate-500", "text-slate-400");

    reservacionContenedor.classList.add("hidden");

    botonReservar.addEventListener('click', () => {
        reservacionContenedor.classList.toggle("hidden");
        if (botonReservar.innerHTML === "Reservar") {
            botonReservar.classList.remove("bg-principal");
            botonReservar.classList.add("bg-red-600");
            botonReservar.innerHTML = "No Reservar";
        } else {
            botonReservar.classList.add("bg-principal");
            botonReservar.classList.remove("bg-red-600");
            botonReservar.innerHTML = "Reservar";
        }
    });

    fechaInicio.addEventListener('change', validation);
    fechaFin.addEventListener('change', validation);

    FinRes.addEventListener('click', () => {
        confirmModal.classList.remove("hidden");
    });

    confirmBtn.addEventListener('click', () => {
        confirmModal.classList.add("hidden");
        reservaForm.submit();
    });

    cancelBtn.addEventListener('click', () => {
        confirmModal.classList.add("hidden");
    });

    function validation() {
        const inicio = new Date(fechaInicio.value);
        const fin = new Date(fechaFin.value);

        const fechaActual = new Date();
        fechaActual.setDate(fechaActual.getDate() + 1);

        if (
            fechaInicio.value &&
            fechaFin.value &&
            fin > inicio &&
            inicio >= fechaActual &&
            fin >= fechaActual
        ) {
            FinRes.disabled = false;
            FinRes.classList.remove("bg-slate-500", "text-slate-400");
            FinRes.classList.add("bg-green-500", "text-white");

            mensajeError.classList.add("hidden");

            calcularTotalReserva(inicio, fin);
        } else {
            FinRes.disabled = true;
            FinRes.classList.remove("bg-green-500", "text-white");
            FinRes.classList.add("bg-slate-500", "text-slate-400");

            mensajeError.classList.remove("hidden");

            totalReserva.textContent = "0.00";
        }
    }

    function calcularTotalReserva(inicio, fin) {
        const diferenciaMs = fin - inicio;
        const diferenciaHoras = diferenciaMs / (1000 * 60 * 60);

        let total = diferenciaHoras * precioPorHora;
        total += precioRenta;

        totalReserva.textContent = total.toFixed(2);
        totalInput.value = total.toFixed(2);
    }
</script>