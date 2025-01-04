<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Clientes
            </h2>

            <a href="{{route("clients.create")}}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</a>
        </div>

        <div class="card px-4 py-4 sm:px-5">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
              <table class="is-hoverable w-full text-left">
                <thead>
                  <tr>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Nome
                    </th>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      E-mail
                    </th>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Quantidade de instâncias
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
                  @foreach ($clients as $client)
                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->user->name}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->user->email}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->quantity_instance}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->status}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <a href="{{route('clients.edit', $client->id)}}"><i class="fas fa-edit"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{$clients->links()}}
            </div>
          </div>
    </main>
</x-app-layout>