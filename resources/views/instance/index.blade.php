<x-app-layout>
    <x-toast />
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Instâncias
            </h2>

            @if($canRegister && auth()->user()->client || !auth()->user()->client)
              <a href="{{route("instances.create")}}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">Cadastrar</a>
            @endif
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
                    Número
                  </th>
                  <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                  >
                    Token
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
                @foreach ($instances as $instance)
                  <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$instance->name}}</td>
                    @if (!auth()->user()->client)
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$instance->client->user->name}}</td>
                    @endif
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$instance->phone}}</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$instance->token}}</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$instance->status}}</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 flex gap-2">
                      @if($instance->status != 'Conectado')
                        <div x-data="instances('{{$instance->id}}', '{{$instance->name}}')" x-init="$watch('showModal', () => socketini())">
                          <button
                            @click="showModal = true"
                            title="Conectar ao Whatsapp"
                          >
                          <i class="fa-brands fa-whatsapp"></i>
                          </button>
                          <template x-teleport="#x-teleport-target">
                            <div
                              class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                              x-show="showModal"
                              role="dialog"
                              @keydown.window.escape="showModal = false"
                            >
                              <div
                                class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                @click="showModal = false"
                                x-show="showModal"
                                x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                              ></div>
                              <div
                                class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                                x-show="showModal"
                                x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                              >
                                <img :src="qrCode" class="w-full h-full">
                              </div>
                            </div>
                          </template>
                        </div>
                      @endif
                      <a href="{{route('instances.recreate', $instance->id)}}" onclick="event.preventDefault(); confirmationMessage('warning', 'Você tem certeza que deseja recriar a instância ?', 'Sim', 'Não', 'form-recreate-instance-{{$instance->id}}')" title="Recriar instância"><i class="fa-solid fa-rotate-right"></i></a>
                      <form action="{{route('instances.recreate', $instance->id)}}" method="post" id="form-recreate-instance-{{$instance->id}}">
                        @csrf
                      </form>
                      <a href="{{route('instances.destroy', $instance->id)}}" onclick="event.preventDefault(); confirmDelete('form-delete-{{$instance->id}}', 'Você realmente deseja excluir este registro ?', 'Sim', 'Não')"><i class="fas fa-trash"></i></a>
                        <form action="{{route('instances.destroy', $instance->id)}}" id="form-delete-{{$instance->id}}" method="post">
                          @csrf
                          @method('delete')
                        </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{$instances->links()}}
          </div>
        </div>
    </main>
@push('scripts')
  <script src="https://cdn.socket.io/4.8.1/socket.io.min.js" integrity="sha384-mkQ3/7FUtcGyoppY6bz/PORYoGqOl7/aSUMn2ymDOJcapfS6PHqxhRTMh1RR0Q6+" crossorigin="anonymous"></script>
  <script src="{{asset('js/confirmation.js')}}"></script>
  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('instances', (instanceId, instanceName) => ({
          showModal: false,
          qrCode: null,
          async socketini() {
            let socket = null;
            if(this.showModal) {
              socket = io(this.wssUrl, {
                transports: ['websocket']
              });

              // socket.on('qrcode.updated', (data) => {
              //   this.qrCode = data.data.qrcode.base64
              // });
              console.log(instanceId);
              

              const {data} = await axios.get(`/api/instances/connect/${instanceId}`)
              this.qrCode = data.base64;
              
              socket.on("connection.update", async (data) => {
                const state = data.data.state;

                if(state == 'open') {
                  this.qrCode = null;
                  this.showModal = false;
                  
                  this.$notification({text:'Whatsapp conectado com sucesso!',variant:'success',position:'right-bottom'})

                  await axios.post(`/api/connection/update/${instanceId}`);

                  setTimeout(() => {
                    window.location.reload();
                  }, 2000);
                }
              })
            } else {
              socket.disconnect();
            }
          },
          wssUrl: `{{$wssUrl}}/${instanceName}`
        }));
    });
  </script>
@endpush
</x-app-layout>

