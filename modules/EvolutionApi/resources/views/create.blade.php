<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Evolution API - Configuração
            </h2>

            <div class="flex items-center gap-2">
                <a href="{{route('integrations.evolutionapi.index')}}" class="btn bg-black font-medium text-white hover:bg-black/60 focus:bg-black/60 active:bg-black/90">Voltar</a>
            </div>
        </div>

        <div>
            <form action="{{route('integrations.evolutionapi.store')}}" method="post">
                @csrf
                <x-input type="text" placeholder="Identificação" :value="old('identification')" name="identification" />
                <x-input type="text" placeholder="URL da API" :value="old('api_url')" name="api_url" />
                <x-input type="text" placeholder="Token Global" :value="old('global_token_api')" name="global_token_api" />
                <x-input type="number" placeholder="Quantidade de instâncias" :value="old('quantity_instances')" name="quantity_instances" />
                <x-input.checkbox label="Ativo" name="is_active" />
                <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Salvar</button>
            </form>
        </div>
    </main>
</x-app-layout>