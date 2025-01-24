<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Planos
            </h2>

            <a href="{{route('plans.index')}}" class="btn bg-black font-medium text-white hover:bg-black-focus focus:bg-black-focus active:bg-black-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Voltar</a>
        </div>
        <div class="card px-4 py-4 sm:px-5">
            <form x-data action="{{route('plans.store')}}" method="post">
                @csrf
                <x-input type="text" placeholder="Nome" :value="old('name')" name="name" />
                <x-input type="number" placeholder="Quantidade de instâncias" :value="old('quantity_instance')" name="quantity_instance" />
                <x-input type="number" placeholder="Quantidade de mensagens" :value="old('quantity_messages')" name="quantity_messages" />
                <small>Usando quantidade 0 as mensagens serão ilimitadas</small>
                <x-input type="text" placeholder="Preço" x-mask:dynamic="$money($input, ',','.', 2)" :value="old('price')" name="price" />
                <x-input.checkbox label="Ativo" name="is_active" />
                <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</button>
            </form>
        </div>
    </main>
    
</x-app-layout>