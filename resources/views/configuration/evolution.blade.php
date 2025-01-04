<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Configuração API Evolution
            </h2>
        </div>
        <div class="card px-4 py-4 sm:px-5">
            <form x-data action="{{route('configuration.evolution.update', $whatsappIntegration->id)}}" method="post">
                @method('PUT')  
                @csrf
                <x-input type="text" placeholder="URL da API" :value="old('base_url', $whatsappIntegration->base_url)" name="base_url" />
                <x-input type="text" placeholder="Token Global" :value="old('token', $whatsappIntegration->token)" name="token" />
    
                <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Salvar</button>
            </form>
        </div>
    </main>
    
</x-app-layout>