<main>
    <style>
        .bg-brightness {
            position: relative;
            width: 100%;
            height: 100vh;
        }

        .bg-brightness::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/hero/rektorat2.jpg');
            background-size: cover;
            background-position: center;
            filter: brightness(0.2);
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
        }
    </style>
    <section class="w-full h-screen bg-brightness">
        <div
            class="max-w-screen-xl w-full mx-auto flex-col lg:flex-row flex items-center h-full content lg:justify-between justify-center px-8 py-24 pt-28">
            <div class="flex flex-col gap-y-1 max-w-lg flex-[1] justify-center">
                <h1 class="text-3xl lg:text-5xl text-white font-black">Survey <span
                        class="text-color-primary-500">Penjamu</span></h1>
                <p class="text-xl lg:text-2xl text-white font-bold mt-4">Universitas Negeri Gorontalo</p>
                <p class="text-white text-sm lg:text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro
                    dolore consequuntur iste hic voluptate sequi saepe a laboriosam magni. Corporis?</p>
            </div>
            <div class="flex flex-[1] justify-end">
                <div class="lg:flex flex-col gap-y-2 self-end mb-4 hidden">
                    <div
                        class="w-44 p-4 bg-color-primary-500 rounded-md text-white text-sm font-bold inline-flex gap-x-3 items-start">
                        <span>
                            <i class="fas fa-poll"></i>
                        </span>
                        Survey Penjamu
                    </div>
                    <div
                        class="w-44 p-4 bg-white rounded-md text-color-primary-500 text-sm font-bold inline-flex gap-x-3 items-start">
                        <span>
                            <i class="fas fa-chart-pie"></i>
                        </span>
                        Survey Dosen
                    </div>
                </div>
                <div class="w-56">
                    <img src="/hero/hero.png" alt="" class="w-full">
                </div>
                <div class="lg:flex flex-col gap-y-2 mt-4 hidden">
                    <div
                        class="w-44 p-4 bg-white rounded-md text-color-primary-500 text-sm font-bold inline-flex gap-x-3 items-start">
                        <span>
                            <i class="fas fa-chart-pie"></i>
                        </span>
                        Infografis
                    </div>
                    <div
                        class="w-44 p-4 bg-white rounded-md text-color-primary-500 text-sm font-bold inline-flex gap-x-3 items-start">
                        <span>
                            <i class="fas fa-columns"></i>
                        </span>
                        Summary
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>