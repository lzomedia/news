@extends('layouts.app')

@section('content')

    <div class="container-fluid py-2">

        <div class="row ">
            <!-- Side widgets-->
            <div class="col-lg-3 ">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-body bg-secondary text-white">
                        Our community is a community of 871,688 amazing developers
                        We're a place where coders share, stay up-to-date and grow their careers.
                    </div>
                </div>
                <!-- Categories widget-->
              <div class="card mb-4">
                  <ul class="no-bull">
                      <li class="">
                          <i class="ri-building-fill"></i>
                          Home
                      </li>
                      <li class="">
                          <i class="ri-login-box-fill"></i>
                          Login
                      </li>
                      <li class="">
                          <i class="ri-rss-fill"></i>
                          Listings
                      </li>
                  </ul>
              </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>


                <div class="card mb-4">
                    <div class="card-header">Popular tags</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>

            </div>


            <!-- Articles !-->
            <div id="home" class="col-lg-6"></div>


            <!-- Side widgets-->
            <div class="col-lg-3">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-unstyled mb-0">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>

        </div>

    </div>



@endsection
