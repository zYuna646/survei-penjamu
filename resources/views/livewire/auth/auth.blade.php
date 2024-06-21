<main class="w-full flex items-center h-screen">
    <section class="flex-[3] w-full lg:flex items-center justify-center bg-color-primary-100 h-full hidden">
        <div class="w-60 relative">
            <img src="/hero/3d-business-man-and-woman-working-at-the-table.png" alt="" class="w-full">
            <div class="absolute -top-16 -left-24 bg-white p-4 max-w-xs rounded-lg rounded-br-none">
                <p class="font-medium text-sm">Bantu isi survei ini ya??</p>
            </div>
            <div
                class="absolute -top-16 -right-8 bg-color-primary-500 text-white p-4 max-w-xs rounded-lg rounded-bl-none">
                <p class="font-bold text-sm">Boleh-boleh aja</p>
            </div>
        </div>
    </section>
    <section class="flex-[4] w-full flex items-center justify-center bg-white h-full px-6">
        <div class="max-w-md w-full flex flex-col gap-y-2">
            <p class="text-sm text-slate-500">Selamat Datang Kembali👋</p>
            <h1 class="text-2xl font-bold">Masuk Ke Akun Kamu</h1>
            <form action="" wire:submit="handleLogin">
                @csrf
                <div class="flex flex-col gap-y-2 mt-2">
                    <label for="credential" class="text-sm ">Kredensial :</label>
                    <input type="credential" name="credential" wire:model="credential"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-primary-500">
                </div>
                <div class="flex flex-col gap-y-2 mt-2">
                    <label for="password" class="text-sm ">Password :</label>
                    <input type="password" name="password" wire:model="password"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-primary-500">
                </div>
                <div class="flex mt-6 px-2">
                    <input class="mr-2 leading-tight" type="checkbox">
                    <label for="credential" class="text-sm ">Tampil Password</label>
                </div>
                <div class="mt-4">
                    <livewire:button colors="primary" customClass="w-full" size="lg" :content="'Login'" type="submit" />
                </div>
                <div class="mt-4">
                    <livewire:button colors="primary" outlined="true" customClass="w-full" size="lg"
                        :content="'Beranda'" />
                </div>
            </form>
        </div>
    </section>
</main>