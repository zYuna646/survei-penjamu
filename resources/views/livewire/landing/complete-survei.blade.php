<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-lg w-full mx-auto px-4 pt-24 gap-4 pb-12">
        <div
            class="p-8 h-fit bg-white rounded-lg border border-slate-100 shadow-sm flex flex-col gap-y-12 items-center">
            <h1 class="text-lg font-bold">Survei Berhasil Diselesaikan!!!</h1>
            <img src="/hero/3d-business-joyful-man-and-woman.png" alt="" class="w-44">
            <div class="flex flex-col gap-y-4 items-center max-w-md">
                <p class="text-center text-sm">Respon kamu pada {{ $dataSurvei['name'] }} telah tersimpan di dalam database</p>
                <x-button class="w-fit" color="info" onclick="window.location.href='{{ route('list_survei') }}'">
                    List Survei
                </x-button>
            </div>

        </div>
    </section>
</main>