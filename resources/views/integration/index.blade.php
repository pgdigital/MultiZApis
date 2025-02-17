<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Plugins
            </h2>

            {{-- @can('create', \App\Models\Module::class)
              <a href="{{route("plans.create")}}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Adicionar plugin</a>
            @endcan --}}
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach($modules as $module)
                <div class="card rounded-lg">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                        <img src="{{$module->informations->thumbnail}}" class="rounded-lg" alt="">
                        <div class="p-2">
                            <div class="flex items-center gap-2">
                                <h4 class="font-medium font-sans antialiased tracking-normal text-lg">{{$module->name}}</h4>
                                <p class="text-green-500 antialiased tracking-normal font-normal font-sans text-md">{{$module->informations->version}}</p>
                            </div>
                            <small class="font-semibold font-sans antialiased tracking-normal">Autor: {{$module->informations->author}}</small>

                            <div class="flex items-center justify-between gap-2 mt-2">
                                <a href="{{route('integrations.toggle.modules', $module->id)}}" onclick="event.preventDefault(); document.getElementById('toggle-module-{{$module->id}}').submit()" @class([
                                    'px-2 py-2 rounded-lg text-white font-semibold font-sans antialiased tracking-normal',
                                    'bg-green-500' => !$module->enabled,
                                    'bg-red-500' => $module->enabled
                                ])>
                                    @if(!$module->enabled)
                                        Ativar
                                    @else
                                        Desativar
                                    @endif
                                </a>
                                <form action="{{route('integrations.toggle.modules', $module->id)}}" id="toggle-module-{{$module->id}}" method="post">
                                    @csrf
                                </form>
                                @if($module->enabled)
                                <a 
                                    href="{{route("integrations.{$module->slug}.index")}}"
                                    x-tooltip.placement.top="'Configuração'"
                                    class="text-warning px-2 py-2 rounded-lg text-white font-semibold font-sans antialiased tracking-normal">
                                    <i class="fas fa-cog text-warning"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</x-app-layout>