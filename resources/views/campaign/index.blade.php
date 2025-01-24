<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Campanhas
            </h2>

            <a href="{{route("campaigns.create")}}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</a>
        </div>

        <div class="card px-4 py-4 sm:px-5">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
              <table class="is-hoverable w-full text-left">
                <thead>
                  <tr>
                    @if(!auth()->user()->client)
                      <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                      >
                        Cliente
                      </th>
                    @endif
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Nome
                    </th>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Tipo
                    </th>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Status
                    </th>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Ações
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($campaigns as $campaign)
                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$campaign->client->user->name}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$campaign->name}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$campaign->type}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$campaign->status}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <a href="{{route('campaigns.edit', $campaign->id)}}"><i class="fas fa-edit"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{$campaigns->links()}}
            </div>
          </div>
    </main>
</x-app-layout>