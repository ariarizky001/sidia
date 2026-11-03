@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-3"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pegawai</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-3"><i class="fas fa-briefcase"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Departemen</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-3"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kehadiran Hari Ini</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-3"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cuti Menunggu</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Selamat Datang</h3>
                </div>
                <div class="card-body">
                    <p>Selamat datang di sistem Informasi Data Pegawai (siDia)!</p>
                    <p>Gunakan menu di sebelah kiri untuk mengelola data pegawai dan informasi terkait.</p>
                    <p>Navigate ke menu <strong>Data Pegawai</strong> untuk melihat dan mengelola informasi pegawai.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
