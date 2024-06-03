<x-app-layout>
  <x-slot name="header">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Event &raquo; {{ $event->name }} &raquo; Transaction
      </h2>
  </x-slot>

  {{-- Confirm Button --}}
  <div id="confirmationModal" class="hidden fixed inset-0 z-50 overflow-auto bg-smoke-light">
      <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg">
          <div>
              <h2 class="text-xl font-bold mb-4">Konfirmasi</h2>
              <p id="modalMessage">Apakah anda yakin ingin mengapprove transaction ini?</p>
          </div>
          <div class="mt-4">
              <button id="confirmButton"
                  class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600
                  transition duration-300 ease-in-out">Ya</button>
              <button id="cancelButton" class="px-4 py-2 bg-gray-300 rounded ml-2">Batal</button>
          </div>
      </div>
  </div>

  {{-- Modal --}}
  <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                  @if (session('success'))
                      <div class="px-4 py-2 mb-4 text-white bg-green-500 rounded">
                          {{ session('success') }}
                      </div>
                  @endif
                  <table class="w-full">
                      <thead class="bg-gray-50">
                          <tr>
                              <th style="max-width: 1%" class="px-6 py-3">ID</th>
                              <th class="px-6 py-3">Code</th>
                              <th class="px-6 py-3">Detail</th>
                              <th class="px-6 py-3">Status</th>
                              <th class="px-6 py-3">Total Price</th>
                              <th class="px-6 py-3">Ticket</th>
                              <th style="max-width: 1%" class="px-6 py-3">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($transactions as $transaction)
                              <tr class="border-b">
                                  <td class="px-6 py-4">{{ $transaction->id }}</td>
                                  <td class="px-6 py-4">{{ $transaction->code }}</td>
                                  <td class="px-6 py-4">{{ $transaction->name }} <br> ({{ $transaction->email }})</td>
                                  <td class="px-6 py-4">{{ $transaction->status }}</td>
                                  <td class="px-6 py-4">${{ number_format($transaction->total_price) }}</td>
                                  <td class="px-6 py-4">
                                      <ol class="list-decimal">
                                          @foreach ($transaction->transactionDetails as $details)
                                              <li>{{ $details->ticket->name }} ({{ $details->code }})</li>
                                          @endforeach
                                      </ol>
                                  </td>
                                  <td class="px-6 py-4 space-y-1 text-sm">
                                      <a href="{{ route('admin.approve', [
                                          'event' => $event->id,
                                          'transaction' => $transaction->id,
                                      ]) }}"
                                          class="approve-btn block w-full px-4 py-2 text-center text-white bg-green-500 rounded">
                                          Approve & Send
                                      </a>
                                      @if ($transaction->status != 'success')
                                          <form
                                              action="{{ route('admin.events.transactions.destroy', [
                                                  'event' => $event->id,
                                                  'transaction' => $transaction->id,
                                              ]) }}"
                                              method="POST" class="block"
                                              onsubmit="return confirm('Hapus transaction {{ $transaction->name }}?')">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit"
                                                  class="w-full px-4 py-2 text-center text-white bg-red-500 rounded">
                                                  Hapus
                                              </button>
                                          </form>
                                      @endif

                                      @if ($transaction->status == 'success')
                                          <a href="{{ route('admin.pdf', [
                                              'event' => $event->id,
                                              'transaction' => $transaction->id,
                                          ]) }}"
                                              class="block w-full px-4 py-2 text-center text-white bg-green-500 rounded">
                                              Download
                                          </a>
                                      @endif
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="mt-4">
                      {{ $transactions->links() }}
                  </div>
              </div>
          </div>
      </div>
  </div>

  {{-- Script Button Confirm --}}
  <script>
      document.addEventListener("DOMContentLoaded", function() {
          const confirmationModal = document.getElementById("confirmationModal");
          const confirmButton = document.getElementById("confirmButton");
          const cancelButton = document.getElementById("cancelButton");
          const modalMessage = document.getElementById("modalMessage");
          document.querySelectorAll(".approve-btn").forEach(button => {

              button.addEventListener("click", function(e) {

                  e.preventDefault();

                  const url = this.href;

                  modalMessage.innerText = "Apakah anda yakin ingin mengapprove transaction ini?";

                  confirmButton.onclick = function() {

                      window.location.href = url;

                  };

                  confirmationModal.classList.remove("hidden");

              });

          });

          cancelButton.addEventListener("click", function() {

              confirmationModal.classList.add("hidden");

          });

      });
  </script>

  {{-- Scrupt Jquery --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

    $(document).ready(function() {

    $('.approve-btn').on('click', function(e) {

    e.preventDefault();

    let url = $(this).attr('href');

    let button = $(this);

    $.ajax({

    url: url,

    type: 'POST',

    data: {

    _token: '{{ csrf_token() }}'

    },

    success: function(response) {

    if (response.success) {

    button.closest('tr').find('td').eq(3).text('success');

    alert(response.message);

    } else {

    alert(response.message);

    }

    },

    error: function() {

    alert('An error occurred while approving the transaction.');

    }

    });

    });

    });

    </script>



</x-app-layout>