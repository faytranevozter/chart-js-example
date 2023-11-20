<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <div class="flex flex-col relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100">
            <div class="grid grid-cols-3">
                <div class="mb-2">
                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">Select user</label>
                    <select id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Choose</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="w-8/12">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        const ctx = document.querySelector('#chart').getContext('2d')
        let chart = null
        const apiURL = '{{ route('get-user') }}'

        const getData = async () => {
            const url = new URL(apiURL)
            const userID = document.querySelector('#user_id').value
            if (userID) {
                url.searchParams.set('user_id', userID)
            }
            const resRaw = await fetch(url.toString())
            const res = await resRaw.json()

            render(res)
        }

        const render = (data) => {
            // destroy chart
            if (chart) {
                chart.destroy()
            }

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.list.map(v => v.month),
                    datasets: [
                        {
                            label: 'In',
                            data: data.list.map(v => v.in),
                            backgroundColor: '#4cbfc0'
                        },
                        {
                            label: 'Out',
                            data: data.list.map(v => v.out),
                            backgroundColor: '#ffa5b4'
                        }
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        // legend: {
                        //     display: false,
                        // },
                        // title: {
                        //     display: true,
                        //     text: 'Grafik Harga'
                        // }
                    }
                },
            })
        }

        document.querySelector('#user_id').addEventListener('change', async (e) => {
            // const value = document.querySelector('#user_id').value
            await getData()
        })

        getData()
    </script>
</html>
