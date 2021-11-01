<x-app-layout>

    <div class="container py-12">

        <section class="grid grid-cols-3 gap-4 text-white">
            <a href="{{ route('orders.index') . "?status=CREATED" }}" class="bg-red-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">    
                    {{$estado > 0 && $status === 'PENDING' ? $estado : 0}}
                </p>
                <p class="uppercase text-center">Pendiente</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-business-time"></i>
                </p>
            </a>

            <a href="{{ route('orders.index') . "?status=APPROVED" }}" class="bg-gray-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$estado > 0 && $status === 'APPROVED' ? $estado : 0}}
                </p>
                <p class="uppercase text-center">Pagado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>           

            <a href="{{ route('orders.index') . "?status=REJECTED" }}" class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">
                    {{$estado > 0 && $status === 'REJECTED' ? $estado : 0}}
                </p>
                <p class="uppercase text-center">Anulado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-times-circle"></i>
                </p>
            </a>
        </section>

        @if ($orders->count())
            
        
            <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <h1 class="text-2xl mb-4">Pedidos recientes</h1>

                <ul>
                    @foreach ($orders as $order)
                        <li>
                            <a href="{{ route('orders.show', $order) }}" class="flex items-center py-2 px-4 hover:bg-gray-100">
                                <span class="w-12 text-center">
                                    @switch($order)
                                        @case('PENDING')
                                            <i class="fas fa-business-time text-red-500 opacity-50"></i>
                                            @break
                                        @case('APPROVED')
                                            <i class="fas fa-credit-card text-gray-500 opacity-50"></i>
                                            @break                                        
                                        @case('REJECTED')
                                            <i class="fas fa-times-circle text-green-500 opacity-50"></i>
                                            @break
                                        @default
                                            
                                    @endswitch
                                </span>

                                <span>
                                    Orden: {{$order->id}}
                                    <br>
                                    {{$order->created_at->format('d/m/Y')}}
                                </span>


                                <div class="ml-auto">
                                    <span class="font-bold">
                                        @switch($order->status)
                                            @case('PENDING')
                                                
                                                Pendiente

                                                @break
                                            @case('APPROVED')
                                                
                                                Pagado

                                                @break
                                            @case('REJECTED')
                                                
                                                Anulado                                              

                                                @break
                                            @default
                                                
                                        @endswitch
                                    </span>

                                    <br>

                                    <span class="text-sm">
                                        {{$order->total}} USD
                                    </span>
                                </div>

                                <span>
                                    <i class="fas fa-angle-right ml-6"></i>
                                </span>

                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>

        @else
        <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <span class="font-bold text-lg">
                No existe registros de ordenes
            </span>
        </div>
        @endif

    </div>

</x-app-layout>