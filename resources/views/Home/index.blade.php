@extends('layouts.main')

@section('main-section')
    <section class="content">

        <section class="box">
            <div class="box-header">
                <h3 class='title'>Dashboard</h3>
            </div>

            <div class="box-body mb-2">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo ea veniam porro quasi, delectus,
                    tempore commodi dolore iste suscipit perspiciatis aliquam atque impedit quam vero laborum asperiores
                    incidunt fugit sit ipsa, dolorem earum optio. Nesciunt?</p>
            </div>

            <div class="box-header">
                <x-zara.link-button-success href="/create-transaction">Buat Transaksi</x-zara.link-button-success>
        </section>

    </section>
@endsection
