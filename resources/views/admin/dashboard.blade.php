@extends('admin.layout')

@section('content')

<style>
.dashboard-title{
    font-size:28px;
    font-weight:600;
    color:#183153;
    margin-bottom:25px;
}

.card-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card h4{
    color:#666;
    font-size:15px;
    margin-bottom:10px;
}

.card h2{
    color:#183153;
    font-size:30px;
}

.card i{
    font-size:45px;
    color:#F77F00;
}

.content-grid{
    display:grid;
    grid-template-columns:1fr;
    gap:20px;
}
.box{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.box h3{
    margin-bottom:20px;
    color:#183153;
}

.activity{
    display:flex;
    align-items:center;
    margin-bottom:18px;
}

.activity i{
    width:35px;
    height:35px;
    border-radius:50%;
    background:#e9f8ef;
    color:green;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-right:15px;
}

.activity p{
    margin:0;
    color:#444;
}

.activity small{
    color:#999;
}

canvas{
    width:100%!important;
    height:350px!important;
}
</style>


<h2 class="dashboard-title">
    Dashboard Admin
</h2>


<div class="card-grid">


    <!-- MAHASISWA -->
    <div class="card">

        <div>
            <h4>Total Mahasiswa</h4>
            <h2>{{ $totalMahasiswa }}</h2>
        </div>

        <i class="fa-solid fa-user-graduate"></i>

    </div>



    <!-- DOSEN & STAF -->
    <div class="card">

        <div>
            <h4>Total Dosen & Staf</h4>
            <h2>{{ $totalDosen + $totalStaf }}</h2>
        </div>

        <i class="fa-solid fa-users"></i>

    </div>



    <!-- ADMIN OPERATOR -->
    <div class="card">

        <div>
            <h4>Admin & Operator</h4>
            <h2>{{ $totalAdmin + $totalOperator }}</h2>
        </div>

        <i class="fa-solid fa-user-shield"></i>

    </div>



    <!-- PENGAJUAN MASUK -->
    <div class="card">

        <div>
            <h4>Pengajuan Masuk</h4>
            <h2>{{ $totalPengajuan }}</h2>
        </div>

        <i class="fa-solid fa-file-circle-plus"></i>

    </div>



    <!-- SELESAI -->
    <div class="card">

        <div>
            <h4>Pengajuan Selesai</h4>
            <h2>{{ $selesai }}</h2>
        </div>

        <i class="fa-solid fa-circle-check"></i>

    </div>


</div>



<div class="content-grid">


    <!-- GRAFIK -->
    <div class="box">

        <h3>Grafik Pengajuan per Bulan</h3>

        <canvas id="chartPengajuan"></canvas>

    </div>



  </div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const ctx = document.getElementById('chartPengajuan');


new Chart(ctx, {

    type:'bar',

    data:{


        labels:[
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ],


        datasets:[{

            label:'Pengajuan',

            data:@json($chart),

            backgroundColor:'#F77F00'

        }]

    },


    options:{


        responsive:true,


        plugins:{

            legend:{

                display:false

            }

        },


        scales:{

            y:{

                beginAtZero:true

            }

        }

    }

});

</script>


@endsection