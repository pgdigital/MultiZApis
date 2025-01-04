<x-app-layout>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <div class="card px-4 py-4 sm:px-5">
                    <div>
                      <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Total de chats: {{$totalChats}}
                      </h2>
                    </div>
                </div>
                <div class="card px-4 py-4 sm:px-5">
                    <div>
                      <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Total de mensagens: {{$totalMessages}}
                      </h2>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
