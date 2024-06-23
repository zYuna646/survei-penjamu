<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24" x-data="{ showModal: false }">
        <div
            class="p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">{{ $master }}</h1>
                <p class="text-slate-500 text-sm">List data {{ $master }} yang berhasil terinput dalam Database</p>
            </div>
            <div>
                <livewire:button content="Tambah {{ $master }}" colors="info" @click="showModal = !showModal" />
            </div>
        </div>
        <div>
            <div x-show="showModal" @click.outside="showModal = false" x-transition
                class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded shadow-lg">
                    <h2 class="text-xl font-bold">Tambah {{ $master }}</h2>
                </div>
            </div>
            <div x-show="showModal" class="fixed inset-0 bg-black opacity-50"></div>
        </div>
    </section>
</main>