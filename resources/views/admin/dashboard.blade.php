@extends('admin.layout')
@section('style')
    <style>
        #alert {
            transition: 0.3s ease-in-out;
        }

        #divisi::-webkit-scrollbar {
            display: none;
        }

        .changeDiv {
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .changeDiv::before {
            content: '';
            width: 0;
            height: 100%;
            border-radius: 0.5rem;
            position: absolute;
            top: 0;
            left: 0;
            transition: .5s ease;
            display: block;
            z-index: -1;
        }

        .changeDiv:hover::before {
            width: 100%;
        }

        #all::before {
            background: linear-gradient(90deg, #EF566A 0%, #627AF7 100%);

        }

        #acara::before {
            background: linear-gradient(90deg, hsla(2, 78%, 62%, 1) 0%, hsla(22, 100%, 78%, 1) 100%);
            position: absolute;
            top: 0;
            left: 0;
        }

        #creative::before {
            background: linear-gradient(90deg, #5AB2F7 0%, #2FEAA8 100%);
        }

        #information_technology::before {
            background: linear-gradient(90deg, hsla(278, 54%, 81%, 1) 0%, hsla(324, 57%, 77%, 1) 50%, hsla(20, 89%, 89%, 1) 100%);
        }

        #kesehatan::before {
            background: linear-gradient(90deg, #fbb034 0%, #ffdd00 74%);
        }

        #konsumsi::before {
            background: linear-gradient(90deg, hsla(175, 79%, 63%, 1) 0%, hsla(82, 96%, 57%, 1) 100%);
        }

        #peran::before {
            background: linear-gradient(90deg, hsla(286, 44%, 49%, 1) 0%, hsla(35, 79%, 68%, 1) 100%);
        }

        #perlengkapan::before {
            background: linear-gradient(90deg, hsla(217, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%);
        }

        #regulasi::before {
            background: linear-gradient(90deg, #1b8b00 0%, #A2D240 74%);
        }

        #sekretariat::before {
            background: linear-gradient(90deg, hsla(17, 95%, 50%, 1) 0%, hsla(42, 94%, 57%, 1) 100%);
        }
    </style>
@endsection

@section('content')
    <div class="w-full h-[90vh] flex flex-col lg:flex-row justify-center items-center justify-center">
        <div class="w-full h-3/4 lg:w-3/4 flex flex-col items-center justify-center mt-5 lg:mt-0 p-3 lg:p-10">
            <div class="mb-10">
                <span id="count" class="font-bold text-xl">0</span>
                <span id="divisi"> orang sudah mendaftar!</p>
            </div>
            <canvas id="chart-funnel-example"></canvas>
        </div>

        <div id="divisi"
            class="max-w-full lg:max-h-[75vh] lg:w-1/4 flex flex-row flex-nowrap lg:flex-col flex-nowrap overflow-x-auto lg:overflow-y-auto lg:overflow-x-hidden items-center snap-x lg:snap-y">

            <button class="snap-center rounded-lg min-w-[20vh] mx-2 lg:mx-0 lg:w-full lg:my-2 min-h-[5rem] flex items-center text-center px-5 cursor-pointer text-white bg-slate-400 relative z-1 changeDiv"
                id="all" value="all" active="true">
                <p class="font-bold">
                    Semua
                </p>
            </button>

            @foreach ($divisions as $division)
                <button
                    class="snap-end rounded-lg min-w-[20vh] mx-2 lg:mx-0 lg:w-full lg:my-2 min-h-[5rem] flex items-center text-start text-white px-5 bg-slate-400 relative z-1 changeDiv"
                    id="{{ strtolower(str_replace(' ', '_', $division->name)) }}" value="{{ $division->id }}"
                    active="false">
                    <p class="font-bold">
                        {{ $division->name }}
                    </p>
                </button>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const colors = {
                "Semua Divisi": "linear-gradient(90deg, #EF566A 0%, #627AF7 100%)",
                "Acara": "linear-gradient(90deg, hsla(2, 78%, 62%, 1) 0%, hsla(22, 100%, 78%, 1) 100%)",
                "Creative": "linear-gradient(90deg, #5AB2F7 0%, #2FEAA8 100%)",
                "Information Technology": "linear-gradient(90deg, hsla(278, 54%, 81%, 1) 0%, hsla(324, 57%, 77%, 1) 50%, hsla(20, 89%, 89%, 1) 100%)",
                "Kesehatan": "linear-gradient(90deg, #fbb034 0%, #ffdd00 74%)",
                "Konsumsi": "linear-gradient(90deg, hsla(175, 79%, 63%, 1) 0%, hsla(82, 96%, 57%, 1) 100%)",
                "Peran": "linear-gradient(90deg, hsla(286, 44%, 49%, 1) 0%, hsla(35, 79%, 68%, 1) 100%)",
                "Perlengkapan": "linear-gradient(90deg, hsla(217, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%)",
                "Keamanan": "linear-gradient(90deg, #1b8b00 0%, #A2D240 74%)",
                "Sekretariat": "linear-gradient(90deg, hsla(17, 95%, 50%, 1) 0%, hsla(42, 94%, 57%, 1) 100%)",
            }

            // Data
            let chartData = {
                type: 'bar',
                data: {
                    labels: ['Data Diri', 'Berkas', 'Jadwal', 'Wawancara'],
                    datasets: [{
                        data: [0, 0, 0, 0],
                        backgroundColor: ['#EF566A', '#ffdd00', '#2FEAA8', '#627AF7'],
                        barPercentage: 1,
                        borderRadius: 8,
                    }],
                },
            };

            // Options
            const chartOptions = {
                dataLabelsPlugin: true,
                options: {
                    indexAxis: 'x',
                    animation: {
                        y: {
                            from: 1000,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                min: 0,
                                maxRotation: 0,
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                return value;
                            },
                            color: '#000000',
                            labels: {
                                title: {
                                    font: {
                                        size: '15',
                                    },
                                    anchor: 'start',
                                    align: 'end',
                                },
                            },
                        },
                    },
                },
            };

            let chart = new Chart(
                document.getElementById("chart-funnel-example"),
                chartData,
                chartOptions,
            );

            $(".changeDiv").eq(0).css("background", colors["Semua Divisi"])
            getData("all")

            $(document.body).on("click", ".changeDiv", function() {
                let id = $(this).attr("value");
                let division = $(this).children().text().trim();

                if (division != "Semua") {
                    $("#divisi").text("orang sudah mendaftar di divisi " + division + '!')
                }
                else {
                    $("#divisi").text("orang sudah mendaftar!")
                }

                $(".changeDiv").each((e) => {
                    $(".changeDiv").eq(e).removeClass("active")
                    $(".changeDiv").eq(e).css("background", "rgb(148 163 184)")
                })

                $(this).addClass("active")
                $(this).css("background", colors[division])

                getData(id)
            })

            function getData(id) {
                $.ajax({
                    url: "{{ route('admin.dashboard.getData') }}",
                    type: "POST",
                    data : {
                        id : id,
                        _token : "{{ csrf_token() }}"
                    },
                    success: function(message) {
                        chart.data.datasets[0].data = message.data
                        chart.update()

                        if (message.data[0] > 0) {
                            const count = message.data[0];
                            let counts = setInterval(updated, 20);
                            let i = 0;

                            function updated() {
                                let text = $("#count");
                                text.text(++i);

                                if (i === count) clearInterval(counts);
                            }
                        } else {
                            $("#count").text("0")
                        }
                    }
                })
            }
        })
    </script>
@endsection
