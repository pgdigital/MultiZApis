<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Campanhas
            </h2>

            <a href="{{route('campaigns.index')}}" class="btn bg-black font-medium text-white hover:bg-black-focus focus:bg-black-focus active:bg-black-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Voltar</a>
        </div>
        <div class="card px-4 py-4 sm:px-5">
            <form x-data action="{{route('campaigns.store')}}" method="post">
                @csrf
                @if(!auth()->user()->client)
                    <x-select label="Cliente" name="client_id" id="client_id">
                        <option value="" disabled selected>Selecione</option>
                        @foreach ($clients as $client )
                            <option value="{{$client->id}}">{{$client->user->name}}</option>
                        @endforeach
                    </x-select>
                @endif
                <x-input type="text" placeholder="Nome" :value="old('name')" name="name" />
                <x-select label="Tipo" name="type" id="type">
                    <option value="" disabled selected>Selecione</option>
                    <option>Em massa</option>
                </x-select>
                <x-input type="datetime-local" label="Data de início" :value="old('start_date')" name="start_date" />
                <x-input type="datetime-local" label="Data de término" :value="old('end_date')" name="end_date" />    
                <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</button>
            </form>
        </div>
    </main>
    
</x-app-layout>