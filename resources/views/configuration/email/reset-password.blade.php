<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Configurações
            </h2>
        </div>
        <div class="tabs flex flex-col">
            <div
                class="is-scrollbar-hidden overflow-x-auto rounded-lg bg-slate-200 text-slate-600 dark:bg-navy-800 dark:text-navy-200">
                <div class="tabs-list flex px-1.5 py-1">
                    <a href="{{route('configuration.index')}}" @class([ 'btn shrink-0 px-3 py-1.5 font-medium'
                        , 'bg-white shadow dark:bg-navy-500 dark:text-navy-100'=>
                        request()->routeIs('configuration.index'),
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100' =>
                        !request()->routeIs('configuration.index'),
                        ])
                        >
                        Principal
                    </a>
                    <a href="{{route('configuration.evolution')}}" @class([ 'btn shrink-0 px-3 py-1.5 font-medium'
                        , 'bg-white shadow dark:bg-navy-500 dark:text-navy-100'=>
                        request()->routeIs('configuration.evolution'),
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100' =>
                        !request()->routeIs('configuration.evolution'),
                        ])
                        >
                        Evolution
                    </a>
                    <a href="{{route('configuration.email.reset-password')}}" @class([ 'btn shrink-0 px-3 py-1.5 font-medium'
                        , 'bg-white shadow dark:bg-navy-500 dark:text-navy-100'=>
                        request()->routeIs('configuration.email.reset-password'),
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100' =>
                        !request()->routeIs('configuration.email.reset-password'),
                        ])
                        >
                        E-mail de resetar senha
                    </a>
                </div>
            </div>
            <div class="tab-content pt-4">
                <div x-transition:enter="transition-all duration-500 easy-in-out"
                    x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                    x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]">
                    <div>
                        <form action="{{route('configuration.email.reset-password.update', $template->id)}}" method="post">
                            @method('PUT')
                            @csrf
                            <x-input type="text" placeholder="Assunto"
                                :value="old('subject', $template->subject)" name="subject" />
                            <div x-data x-init="new SimpleMDE({element: $refs.textarea, toolbar:false})">
                                <textarea x-ref="textarea" name="content" cols="30" rows="10">{{old('content', $template->content)}}</textarea>
                            </div>  
                            <button
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>