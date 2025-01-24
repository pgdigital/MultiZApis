<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Clientes
            </h2>

            <a href="{{route('clients.index')}}" class="btn bg-black font-medium text-white hover:bg-black-focus focus:bg-black-focus active:bg-black-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Voltar</a>
        </div>
        <div class="card px-4 py-4 sm:px-5">
            <form x-data action="{{route('clients.update', $client->id)}}" method="post">
                @csrf
                @method('put')
                <x-select label="Plano" id="plan_id" name="plan_id">
                    <option value="" disabled selected>Selecione</option>
                    @foreach ($plans as $plan)
                        <option value="{{$plan->id}}" @selected(old('plan_id', $client->plan_id) == $plan->id)>{{$plan->name}}</option>
                    @endforeach
                </x-select>
                <x-input type="text" placeholder="Nome" :value="old('name', $client->user->name)" name="name" />
                <x-input type="email" placeholder="E-mail" :value="old('email', $client->user->email)" name="email" />
                <x-input type="text" x-mask="(99) 99999-9999" placeholder="Celular" :value="old('phone', $client->phone)" name="phone" />
                <x-select label="Status" id="status" name="status">
                    <option @selected($client->status == 'Ativo')>Ativo</option>
                    <option @selected($client->status == 'Inativo')>Inativo</option>
                </x-select>    
    
                <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Salvar</button>
            </form>
        </div>
    </main>
    
</x-app-layout>