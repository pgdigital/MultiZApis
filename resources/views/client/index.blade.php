<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Clientes
            </h2>

            @can('create', \App\Models\Client::class)
              <a href="{{route("clients.create")}}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</a>
            @endcan
        </div>

        <div class="card px-4 py-4 sm:px-5">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
              <table class="is-hoverable w-full text-left">
                <thead>
                  <tr>
                    <th
                      class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                    >
                      Plano
                    </th>
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
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->plan->name}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->user->name}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->user->email}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$client->status}}</td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <div class="flex items-center gap-2">
                          @can('update', $client)
                            <a href="{{route('clients.edit', $client->id)}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('clients.reset-password', $client->id)}}" title="Reset de senha" onclick="event.preventDefault(); document.getElementById('form-reset-password-{{$client->id}}').submit()"><i class="fas fa-exchange-alt"></i></a>
                            <form action="{{route('clients.reset-password', $client->id)}}" id="form-reset-password-{{$client->id}}" method="post">
                              @csrf
                            </form>
                          @endcan
                          
                          @can('delete', $client)
                            <a href="{{route('clients.destroy', $client->id)}}" onclick="event.preventDefault(); confirmDelete('form-delete-{{$client->id}}', 'Você realmente deseja excluir este registro ?', 'Sim', 'Não')"><i class="fas fa-trash"></i></a>
                            <form action="{{route('clients.destroy', $client->id)}}" id="form-delete-{{$client->id}}" method="post">
                              @csrf
                              @method('delete')
                            </form>
                          @endcan
                        </div>
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