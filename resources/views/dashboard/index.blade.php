@extends('layouts.app')

@section('title', 'Dashboard')

@section('namaPage', 'Dashboard')

@section('content')
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--success">
                    <div class="card-inner">
                        <h5 class="card-title">Borrowed</h5>
                        <h5 class="font-weight-light pb-2 mb-1 border-bottom">$62,0076.00</h5>
                        <p class="tx-12 text-muted">48% target reached</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons">dvr</i>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--danger">
                    <div class="card-inner">
                        <h5 class="card-title">Annual Profit</h5>
                        <h5 class="font-weight-light pb-2 mb-1 border-bottom">$1,958,104.00</h5>
                        <p class="tx-12 text-muted">55% target reached</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons">attach_money</i>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--primary">
                    <div class="card-inner">
                        <h5 class="card-title">Lead Conversion</h5>
                        <h5 class="font-weight-light pb-2 mb-1 border-bottom">$234,769.00</h5>
                        <p class="tx-12 text-muted">87% target reached</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons">trending_up</i>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--info">
                    <div class="card-inner">
                        <h5 class="card-title">Average Income</h5>
                        <h5 class="font-weight-light pb-2 mb-1 border-bottom">$1,200.00</h5>
                        <p class="tx-12 text-muted">87% target reached</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons">credit_card</i>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card bg-success text-white">
                    <div class="d-flex justify-content-between">
                        <h3 class="font-weight-normal">Impressions</h3>
                        <i class="material-icons options-icon text-white">more_vert</i>
                    </div>
                    <div class="mdc-layout-grid__inner align-items-center">
                        <div
                            class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                            <div>
                                <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                                <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                            </div>
                        </div>
                        <div
                            class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                            <canvas id="impressions-chart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card bg-info text-white">
                    <div class="d-flex justify-content-between">
                        <h3 class="font-weight-normal">Traffic</h3>
                        <i class="material-icons options-icon text-white">more_vert</i>
                    </div>
                    <div class="mdc-layout-grid__inner align-items-center">
                        <div
                            class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                            <div>
                                <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                                <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                            </div>
                        </div>
                        <div
                            class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                            <canvas id="traffic-chart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection